
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photobooth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
            overflow: hidden;
        }

        .noise {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800"><g fill-opacity="0.15"><circle fill="%232d3748" cx="400" cy="400" r="600"/><circle fill="%234a5568" cx="400" cy="400" r="500"/><circle fill="%23718096" cx="400" cy="400" r="400"/><circle fill="%23a0aec0" cx="400" cy="400" r="300"/><circle fill="%23cbd5e0" cx="400" cy="400" r="200"/><circle fill="%23e2e8f0" cx="400" cy="400" r="100"/></g></svg>');
            opacity: 0.05;
        }

        .glow-btn {
            box-shadow: 0 0 15px rgba(76, 175, 80, 0.6), 0 0 25px rgba(76, 175, 80, 0.4);
            transition: all 0.3s ease-in-out;
        }

        .glow-btn:hover {
            box-shadow: 0 0 25px rgba(76, 175, 80, 0.8), 0 0 40px rgba(76, 175, 80, 0.6);
        }

        #photo-screen {
            display: none;
        }

        #countdown {
            font-size: 10rem;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
        }

        #timer {
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        }

        .gallery-img {
            border: 2px solid #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s ease-in-out;
        }
        .gallery-img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="noise"></div>

    <!-- Start Screen -->
    <div id="start-screen" class="text-center p-8 bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-2xl max-w-md w-full">
        <h1 class="text-4xl font-bold mb-4">Photobooth</h1>
        <p class="text-gray-300 mb-8">Masukan email Anda untuk memulai sesi foto.</p>
        <input type="email" id="email" placeholder="contoh@email.com" class="w-full px-4 py-3 rounded-lg bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500 mb-6">
        <button id="start-btn" class="w-full bg-green-500 text-white font-bold py-3 px-6 rounded-lg glow-btn">Mulai</button>
        <p id="email-error" class="text-red-500 mt-4" style="display: none;">Email tidak boleh kosong.</p>
    </div>

    <!-- Photo Screen -->
    <div id="photo-screen" class="w-full h-full">
        <div class="absolute top-5 left-5 z-20 bg-black/50 px-4 py-2 rounded-lg">
            <p class="text-2xl font-semibold">Sisa Waktu: <span id="timer">10:00</span></p>
        </div>
        <div id="countdown-overlay" class="absolute inset-0 flex items-center justify-center bg-black/70 z-30" style="display: none;">
            <p id="countdown"></p>
        </div>
        <video id="camera-feed" class="w-full h-screen object-cover" autoplay playsinline></video>
        <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent">
             <div id="gallery" class="flex justify-center gap-4 mt-4 overflow-x-auto pb-2">
                 <!-- Captured photos will be appended here -->
             </div>
        </div>
    </div>
    <canvas id="canvas" style="display:none;"></canvas>

    <script>
        const startScreen = document.getElementById('start-screen');
        const photoScreen = document.getElementById('photo-screen');
        const startBtn = document.getElementById('start-btn');
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('email-error');
        const cameraFeed = document.getElementById('camera-feed');
        const countdownOverlay = document.getElementById('countdown-overlay');
        const countdownDisplay = document.getElementById('countdown');
        const timerDisplay = document.getElementById('timer');
        const canvas = document.getElementById('canvas');
        const gallery = document.getElementById('gallery');

        let sessionInterval;
        let captureInterval;

        startBtn.addEventListener('click', () => {
            if (emailInput.value.trim() === '') {
                emailError.style.display = 'block';
                return;
            }
            emailError.style.display = 'none';
            
            startScreen.style.display = 'none';
            photoScreen.style.display = 'block';

            startPhotoSession();
        });

        async function startPhotoSession() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                cameraFeed.srcObject = stream;
                
                startCountdown();
            } catch (err) {
                console.error("Error accessing camera: ", err);
                alert("Tidak dapat mengakses kamera. Pastikan Anda memberikan izin.");
                // Reset UI
                startScreen.style.display = 'block';
                photoScreen.style.display = 'none';
            }
        }
        
        function startCountdown() {
            countdownOverlay.style.display = 'flex';
            let count = 5;
            countdownDisplay.textContent = count;

            const interval = setInterval(() => {
                count--;
                if (count > 0) {
                    countdownDisplay.textContent = count;
                } else {
                    clearInterval(interval);
                    countdownOverlay.style.display = 'none';
                    startSessionTimer();
                }
            }, 1000);
        }

        function startSessionTimer() {
            let duration = 10 * 60; // 10 minutes in seconds

            // Start automatic capture
            captureInterval = setInterval(capturePhoto, 10000); // Capture every 10 seconds

            sessionInterval = setInterval(() => {
                const minutes = Math.floor(duration / 60);
                let seconds = duration % 60;
                
                seconds = seconds < 10 ? '0' + seconds : seconds;
                
                timerDisplay.textContent = `${minutes}:${seconds}`;

                if (--duration < 0) {
                    clearInterval(sessionInterval);
                    clearInterval(captureInterval);
                    alert("Sesi foto telah berakhir!");
                    // Reset UI to start screen
                    window.location.reload();
                }
            }, 1000);
        }

        function capturePhoto() {
            const context = canvas.getContext('2d');
            canvas.width = cameraFeed.videoWidth;
            canvas.height = cameraFeed.videoHeight;
            context.drawImage(cameraFeed, 0, 0, canvas.width, canvas.height);

            const dataUrl = canvas.toDataURL('image/png');
            
            const img = document.createElement('img');
            img.src = dataUrl;
            img.className = 'w-24 h-16 object-cover rounded-lg gallery-img';
            gallery.appendChild(img);
            gallery.scrollLeft = gallery.scrollWidth;
        }

    </script>
</body>
</html>
