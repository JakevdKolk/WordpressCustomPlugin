async function loadJokes(container) {
  container.innerHTML = "Loading…";

  const url = new URL(SjaakieJokes.ajaxUrl);

  url.searchParams.set("action", "sjaakie_get_jokes");
  url.searchParams.set("nonce", SjaakieJokes.nonce);

  try {
    const res = await fetch(url.toString());
    const json = await res.json();

    if (!json.success) {
      container.textContent = json.data?.message || "Failed.";
      return;
    }

    const data = json.data;
    const jokes = Array.isArray(data.jokes)
      ? data.jokes
      : data.joke
      ? [data]
      : [];

    if (jokes.length === 0 && data.setup) {
      jokes.push(data);
    } else if (jokes.length === 0) {
      container.textContent = "No jokes found.";
      return;
    }

    container.innerHTML = jokes
      .map((j) => {
        if (j.type === "twopart") {
          return `<div class="sjaakie-joke"><p>${esc(
            j.setup
          )}</p><p><strong>${esc(j.delivery)}</strong></p></div>`;
        }
        return `<div class="sjaakie-joke"><p>${esc(j.joke)}</p></div>`;
      })
      .join("");
  } catch (error) {
    console.error(error);
    container.textContent = "Error loading jokes.";
  }
}

function esc(s) {
  return String(s ?? "")
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

document.addEventListener("DOMContentLoaded", function () {
  const button = document.querySelector(".sjaakie-jokes-load");
  const container = document.querySelector(".sjaakie-jokes-output");

  if (button && container) {
    button.addEventListener("click", function (e) {
      e.preventDefault(); 
      loadJokes(container);
    });
  }
});
