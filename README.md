### 🚀 Docker Commands

#### 1. **Project opstarten (bouwen en runnen)**
Gebruik dit commando om containers te bouwen en in de achtergrond op te starten:
```bash
docker compose up -d --build
```

#### 2. **Project volledig verwijderen**
Als je het project wilt stoppen en **volledig van je systeem wilt verwijderen** (inclusief volumes, netwerken en images):
```bash
docker compose down -v --remove-orphans --rmi all
```

#### 3. **Containers starten via de CLI**
Om bestaande containers te starten (zonder opnieuw te bouwen):
```bash
docker compose start [service]
```
- De `service` is optioneel.
- Laat je het weg, dan worden alle services gestart.
- Voor een specifieke service zoals WordPress (`wp`):
```bash
docker compose start wp
```


### 4. **SFTP connectie**
Voor de SFTP zijn bepaalde dingen belangrijk.
1: Je moet wordpress mounten. Zodat de SFTP een folder heeft die in verband staat met wordpress
2: De SFTP heeft een profile gekregen hierdoor word het niet altijd gebuild om deze te builden en te runnen gebruik de commande
```bash
docker compose --profile SFTP up -d --build
```
3: Je moet waarschijnlijk de timeout verhogen in een FTP client zoals fillezila hij kan even duren met connectie leggen
4: Maak verbinding met de SFTP
- 4.1 : Je kan ook met terminal connectie leggen dit doe je door de commando: 
	```bash
	sftp -P 2222 username@localhost
	``` 
	- username geef je aan in de .env file
	- localhost is de naam van het DOMAIN
- 4.2: Je kan ook met een FTP client connectie leggen dit doe je door de volgende stappen:
	- Host: localhost
	- Port: 2222
	- Protocol: SFTP
	- Username: username (deze geef je aan in de .env file)
	- Password: password (deze geef je aan in de .env file)
5: Als je ooit de container opnieuw moet builden kan er een probleem zijn met de SSH keys. Dit kan je oplossen door de SSH keys te verwijderen. Dit doe je door het volgende commando in te voeren:
```bash
ssh-keygen -R [localhost]:2222
```