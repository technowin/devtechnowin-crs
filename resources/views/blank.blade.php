@extends('layouts.appnew')
@section('pageTitle', 'Dashboard')
@section('page-css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    * {
        font-family: 'Inter', sans-serif;
    }
    
    .welcome-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        /* background: linear-gradient(135deg, #0b1a36 0%, #764ba2 100%); */
        background: linear-gradient(135deg, #969696 0%, #faf5ff 100%);

       
        border-radius: 20px;
        margin: 20px;
        position: relative;
        overflow: hidden;
        animation: bgShift 8s ease infinite;
        background-size: 200% 200%;
    }
    
    @keyframes bgShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Subtle background pattern overlay */
    .welcome-container::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
    }
    
    .welcome-card {
        background: white;
        border-radius: 32px;
        padding: 60px 80px;
        text-align: center;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: float 6s ease-in-out infinite;
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(2px);
    }
    
    .welcome-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.4);
    }
    
    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
        100% {
            transform: translateY(0px);
        }
    }
    
    .welcome-content h1 {
        font-size: 56px;
        font-weight: 800;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #0b1a36 0%, #764ba2 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: fadeInDown 0.8s ease;
        letter-spacing: -0.02em;
    }
    
    .welcome-content p {
        font-size: 20px;
        font-weight: 500;
        background: linear-gradient(135deg, #0b1a36 0%, #764ba2 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: fadeInUp 0.8s ease;
        margin-top: 10px;
    }
    
    .wave-emoji {
        display: inline-block;
        animation: wave 1.5s infinite;
        transform-origin: 70% 70%;
        font-size: 56px;
        background: none;
        -webkit-background-clip: unset;
        background-clip: unset;
        color: #764ba2;
    }
    
    @keyframes wave {
        0% { transform: rotate(0deg); }
        20% { transform: rotate(20deg); }
        40% { transform: rotate(-10deg); }
        60% { transform: rotate(15deg); }
        80% { transform: rotate(-5deg); }
        100% { transform: rotate(0deg); }
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Pulse animation for subtle card glow */
    .pulse-glow {
        animation: pulseGlow 2s ease-in-out infinite;
    }
    
    @keyframes pulseGlow {
        0% {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        50% {
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(118, 75, 162, 0.2);
        }
        100% {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    }
    
    /* Decorative elements */
    .decor-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(5px);
        z-index: 1;
        animation: floatDecor 8s ease-in-out infinite;
    }
    
    .decor-circle-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        background: rgba(118, 75, 162, 0.3);
    }
    
    .decor-circle-2 {
        width: 200px;
        height: 200px;
        bottom: -80px;
        left: -80px;
        background: rgba(11, 26, 54, 0.3);
        animation-delay: 2s;
    }
    
    .decor-circle-3 {
        width: 150px;
        height: 150px;
        top: 50%;
        left: 10%;
        background: rgba(118, 75, 162, 0.2);
        animation-delay: 4s;
    }
    
    @keyframes floatDecor {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(10deg); }
    }
    
    /* Date display */
    .date-badge {
        margin-top: 25px;
        padding-top: 20px;
        display: inline-block;
    }
    
    .date-badge span {
        font-size: 14px;
        color: #764ba2;
        font-weight: 600;
        background: rgba(118, 75, 162, 0.1);
        padding: 8px 20px;
        border-radius: 50px;
        display: inline-block;
    }
    
    @media (max-width: 768px) {
        .welcome-card {
            padding: 40px 30px;
            margin: 20px;
        }
        .welcome-content h1 {
            font-size: 32px;
        }
        .wave-emoji {
            font-size: 32px;
        }
        .welcome-content p {
            font-size: 16px;
        }
    }
</style>
@stop

@section('content')
<div class="container-fluid">
    <div class="welcome-container">
        <!-- Decorative circles -->
        <div class="decor-circle decor-circle-1"></div>
        <div class="decor-circle decor-circle-2"></div>
        <div class="decor-circle decor-circle-3"></div>
        
        <div class="welcome-card pulse-glow">
            <div class="welcome-content">
                <h1>
                    Welcome, {{ Auth::user()->name }}!
                    <!-- <span class="wave-emoji">!!!</span> -->
                </h1>
                <p id="greeting-message">Good to see you here. Have a great day!</p>
                <div class="date-badge">
                    <span><i class="glyphicon glyphicon-calendar"></i> {{ date('l, F j, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
    // Dynamic greeting based on time of day
    var hour = new Date().getHours();
    var greeting = '';
    var emoji = '';
    
    if (hour < 12) {
        greeting = 'Good Morning';
        emoji = 'Start your day with positivity!';
    } else if (hour < 17) {
        greeting = 'Good Afternoon';
        emoji = 'Stay productive and focused!';
    } else {
        greeting = 'Good Evening';
        emoji = 'Time to unwind and relax!';
    }
    
    $('#greeting-message').html(greeting + '! ' + emoji);
</script>
@endsection