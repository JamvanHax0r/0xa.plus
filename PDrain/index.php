<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>0xa.plus | Pixeldrain Extractor</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;600;700&display=swap');
    
    :root {
        --bg-main: #0d1117;
        --card-bg: #161b22;
        --border-glow: rgba(56, 189, 248, 0.25);
        --accent: #38bdf8;
        --accent-hover: #0284c7;
        --text-main: #c9d1d9;
        --text-dim: #8b949e;
        --neon-pink: #f472b6;
    }
    body {
        background-color: var(--bg-main);
        color: var(--text-main);
        font-family: 'Fira Code', monospace;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
        box-sizing: border-box;
        background-image: radial-gradient(circle at 50% 0%, #1e293b 0%, var(--bg-main) 70%);
    }
    .container {
        background: var(--card-bg);
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 0 40px -10px var(--border-glow);
        width: 100%;
        max-width: 460px;
        border: 1px solid #30363d;
        position: relative;
        overflow: hidden;
    }
    .container::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--accent), var(--neon-pink));
    }
    .header-box {
        text-align: center;
        margin-bottom: 35px;
    }
    h2 {
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 0 0 10px 0;
        font-size: 20px;
        font-weight: 700;
    }
    .subtitle {
        color: var(--text-dim);
        font-size: 12px;
        line-height: 1.6;
        margin: 0;
    }
    .input-group {
        margin-bottom: 20px;
        position: relative;
    }
    .input-group::before {
        content: '>';
        position: absolute;
        left: 16px;
        top: 15px;
        color: var(--accent);
        font-weight: bold;
    }
    input[type="text"] {
        width: 100%;
        padding: 15px 16px 15px 40px;
        background: #010409;
        border: 1px solid #30363d;
        color: #58a6ff;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 13px;
        font-family: 'Fira Code', monospace;
        transition: all 0.3s ease;
    }
    input[type="text"]:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 12px var(--border-glow);
    }
    input::placeholder { color: #484f58; }
    button {
        width: 100%;
        padding: 15px;
        background: transparent;
        color: var(--accent);
        border: 1px solid var(--accent);
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-family: 'Fira Code', monospace;
        transition: all 0.2s ease;
        margin-top: 5px;
    }
    button:hover {
        background: var(--accent);
        color: #000;
        box-shadow: 0 0 15px var(--border-glow);
    }
    button:disabled {
        background: #21262d;
        color: #8b949e;
        border-color: #30363d;
        cursor: not-allowed;
        box-shadow: none;
    }
    pre {
        background: #010409;
        padding: 16px;
        border-radius: 6px;
        overflow-x: auto;
        color: #3fb950;
        margin-top: 25px;
        font-size: 12px;
        display: none;
        border: 1px solid #30363d;
        line-height: 1.5;
    }
    .footer {
        margin-top: 40px;
        text-align: center;
        font-size: 12px;
        color: var(--text-dim);
        line-height: 1.8;
        font-family: system-ui, -apple-system, sans-serif;
    }
    .footer p { margin: 4px 0; }
    .nick-jh {
        background: linear-gradient(90deg, #38bdf8, #818cf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: 0.5px;
    }
    .sup-bcc { color: #10b981; font-weight: 600; }
    .sup-flm { color: #f59e0b; font-weight: 600; }
    .sup-fiony { color: var(--neon-pink); font-weight: 700; letter-spacing: 0.5px; }
    .copyright {
        margin-top: 12px !important;
        font-size: 11px;
        color: #484f58;
    }
</style>
</head>
<body>

<div class="container">
    <div class="header-box">
        <h2>PDrain Extractor</h2>
        <p class="subtitle">Direct Link Generator via 0xa.plus Proxy. Max speed execution in stealth mode.</p>
    </div>

    <div class="input-group">
        <input type="text" id="targetUrl" placeholder="https://pixeldrain.com/u/..." autocomplete="off">
    </div>
    
    <button id="btnGas">Execute /_</button>
    <pre id="resultBox"></pre>
</div>

<div class="footer">
    <p>Made with ❤ by <span class="nick-jh">JamvanHax0r</span></p>
    <p>Supported by: <span class="sup-bcc">BCCTeam</span> - <span class="sup-flm">FLMGroup</span> - <span class="sup-fiony">Fiony Bot</span></p>
    <p class="copyright">&copy; <span id="autoYear"></span> - All Rights Reserved</p>
</div>

<script>
    document.getElementById('autoYear').textContent = new Date().getFullYear();

    const btn = document.getElementById('btnGas');
    const inputUrl = document.getElementById('targetUrl');
    const resBox = document.getElementById('resultBox');

    btn.addEventListener('click', async () => {
        const url = inputUrl.value.trim();
        
        if (!url) {
            alert('URL Pixeldrain kosong mutlak, bray!');
            inputUrl.focus();
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Parsing Data...';
        resBox.style.display = 'block';
        resBox.style.color = '#d29922';
        resBox.style.borderColor = '#9e6a03';
        resBox.textContent = 'Fetching headers dari server 0xa.plus...';

        try {
            const req = await fetch('jh.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ url: url })
            });

            const res = await req.json();
            
            if(res.status) {
                resBox.style.color = '#3fb950';
                resBox.style.borderColor = '#238636';
            } else {
                resBox.style.color = '#f85149';
                resBox.style.borderColor = '#b31d28';
            }
            
            resBox.textContent = JSON.stringify(res, null, 2);
        } catch (e) {
            resBox.style.color = '#f85149';
            resBox.style.borderColor = '#b31d28';
            resBox.textContent = 'Fatal Error: ' + e.message;
        } finally {
            btn.disabled = false;
            btn.textContent = 'Execute /_';
        }
    });

    inputUrl.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') btn.click();
    });
</script>
</body>
</html>
