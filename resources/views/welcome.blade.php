<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palang Pintu Kereta Api</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
        }
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 80px 200px;
            max-width: 400px;
            width: 100%; 
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden; /* Agar teks tidak keluar dari container */
        }
        h1 {
            margin: 0;
            padding-bottom: 20px;
            font-size: 24px;
            color: #2c3e50;
            width: 100%;
            text-align: center;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }
        button {
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin: 10px 0; 
            width: 100%; 
        }
        button:hover {
            background-color: #0add2e;
        }
        /* Marquee berjalan penuh dalam container */
        .marquee-container {
            width: 100%;
            height: 40px;
            overflow: hidden;
            background-color: red;
            color: white;
            display: flex;
            align-items: center;
            position: relative;
            border-radius: 5px;
            margin-top: 10px;
            visibility: hidden; /* Awalnya disembunyikan */
        }
        .marquee-text {
            display: inline-block;
            white-space: nowrap;
            padding: 10px;
            font-weight: bold;
            position: absolute;
            animation: marquee 8s linear infinite;
        }
        @keyframes marquee {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(100%);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Palang Pintu Kereta Api</h1>
        
        <form id="open-gate-form">
            <button type="submit">Buka Palang Pintu</button>
        </form>

        <form id="close-gate-form">
            <button type="submit">Tutup Palang Pintu</button>
        </form>

        <!-- Marquee untuk status dalam container -->
        <div class="marquee-container" id="marquee">
            <div id="marquee-text" class="marquee-text">.................</div>
        </div>
    </div>

    <script>
        async function sendCommand(url, message) {
            try {
                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                let data = await response.json();
                document.getElementById('marquee-text').innerText = message;
                document.getElementById('marquee').style.visibility = "visible";
            } catch (error) {
                document.getElementById('marquee-text').innerText = "Koneksi gagal, coba lagi!";
                document.getElementById('marquee').style.visibility = "visible";
            }
        }

        document.getElementById('open-gate-form').addEventListener('submit', function(e) {
            e.preventDefault();
            sendCommand('/api/open-gate', "🚦 Palang pintu dibuka, hati-hati !");
        });

        document.getElementById('close-gate-form').addEventListener('submit', function(e) {
            e.preventDefault();
            sendCommand('/api/close-gate', "🚧 Palang pintu ditutup !");
        });
    </script>
</body>
</html>
