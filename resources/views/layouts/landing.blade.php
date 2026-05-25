<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redragon - Bring Your Ideas to Life</title>
        <link rel="icon" href="{!! asset('public/uploads/'.$setting->favicon) !!}" type="image/png">
    <!-- Font Css -->
    <link href="{{url('/')}}/public/landing/assets/css/stylesheet.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{url('/')}}/public/landing/assets/css/style.css" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{url('/')}}/public/landing/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart link -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">


</head>

<body>






    @stack('css')
    {!! $setting->google_analytics !!}
    </head>

    <body>

        <div class="page-scroll-area">
            @include('elements.landing_header')

            @yield('content')

            @include('elements.landing_footer')
        </div>




 <script>
            // Card rotation
            const indicatorDots = document.querySelectorAll('.indicator-dot');
            const premiumCard = document.querySelector('.premium-rotating-card');

            const cardData = [
                { icon: '🎨', name: 'Creative Studio', type: 'Art & Design', raised: '$45K', goal: '$100K', backers: '1.2K', days: '15', progress: 45 },
                { icon: '🎮', name: 'Gaming Console', type: 'Tech Project', raised: '$250K', goal: '$500K', backers: '5.2K', days: '22', progress: 50 },
                { icon: '🎬', name: 'Documentary', type: 'Film Project', raised: '$85K', goal: '$150K', backers: '2.1K', days: '8', progress: 57 }
            ];

            let currentCardIndex = 0;
            let autoRotateInterval;

            function updateCard(index) {
                const data = cardData[index];
                const card = premiumCard;

                card.style.animation = 'none';
                setTimeout(() => {
                    card.querySelector('.card-icon-large').textContent = data.icon;
                    card.querySelector('.card-project-name').textContent = data.name;
                    card.querySelector('.card-project-type').textContent = data.type;
                    card.querySelectorAll('.stat-value-card')[0].textContent = data.raised;
                    card.querySelectorAll('.stat-value-card')[1].textContent = data.goal;
                    card.querySelectorAll('.stat-value-card')[2].textContent = data.backers;
                    card.querySelectorAll('.stat-value-card')[3].textContent = data.days;
                    card.querySelector('.progress-value-card').textContent = data.progress + '%';
                    card.querySelector('.progress-fill-card').style.width = data.progress + '%';

                    card.style.animation = 'cardSlideIn 0.8s ease both';
                }, 50);

                indicatorDots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === index);
                });
            }

            function autoRotate() {
                currentCardIndex = (currentCardIndex + 1) % cardData.length;
                updateCard(currentCardIndex);
            }

            indicatorDots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentCardIndex = index;
                    updateCard(index);
                    clearInterval(autoRotateInterval);
                    autoRotateInterval = setInterval(autoRotate, 5000);
                });
            });

            autoRotateInterval = setInterval(autoRotate, 5000);

            // Mobile menu
            const navToggle = document.getElementById('navToggle');
            const navMenu = document.getElementById('navMenu');

            navToggle.addEventListener('click', () => {
                navToggle.classList.toggle('active');
                navMenu.classList.toggle('active');
            });

            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    navToggle.classList.remove('active');
                    navMenu.classList.remove('active');
                });
            });

            // Smooth scroll
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });
        </script>
        <!-- Scripts -->
        <script src="{{url('/')}}/public/landing/assets/js/jquery.js"></script>
        <script src="{{url('/')}}/public/landing/assets/js/bootstrap.bundle.min.js"></script>
         <script src="{{url('/')}}/public/landing/assets/js/custom.js"></script>

        @stack('js')
    </body>

</html>