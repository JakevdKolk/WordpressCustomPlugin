async function loadJokes(container) {
  container.innerHTML = "Loading…";

  const url = new URL(SjaakieJokes.ajaxUrl);
  url.searchParams.set("action", "sjaakie_get_jokes");
  url.searchParams.set("nonce", SjaakieJokes.nonce);

  const res = await fetch(url.toString(), { credentials: "same-origin" });
  const json = await res.json();

  if (!json.success) {
    container.textContent = json.data?.message || "Failed.";
    return;
  }

  const data = json.data;
  const jokes = Array.isArray(data.jokes) ? data.jokes : [data];

  container.innerHTML = jokes.map(j => {
    if (j.type === "twopart") {
      return `<div class="sjaakie-joke"><p>${esc(j.setup)}</p><p><strong>${esc(j.delivery)}</strong></p></div>`;
    }
    return `<div class="sjaakie-joke"><p>${esc(j.joke)}</p></div>`;
  }).join("");
}

function esc(s){return String(s??"").replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;").replaceAll('"',"&quot;").replaceAll("'","&#039;");}
