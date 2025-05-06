<?php
  // Starting session for potential flash messages
  session_start();

  // Define the launch date
  $launch_date = "August 8, 2025";

  // Handle form submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    require_once 'send_email.php';
    
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $name = explode('@', $email)[0]; // Use the part before @ as name
    
    if (sendWelcomeEmail($email, $name)) {
      $_SESSION['success'] = "Thank you for signing up! A welcome email has been sent to your inbox.";
    } else {
      $_SESSION['error'] = "Failed to send welcome email. Please try again later.";
    }
    
    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Ryhze - Coming Soon</title>
  <meta name="description" content="Ryhze is a unified content platform powered by blockchain technology, providing true ownership for creators and users. Launch date: August 8, 2025.">

  <!-- Space Grotesk Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    /* Primary Colors & Variables */
    :root {
      /* Color System */
      --deep-purple: #2E1760;
      --royal-purple: #4B2D9E;
      --coral-red: #FF6B6B;
      --teal: #00BFB3;
      --electric-purple: #7B61FF;
      --off-white: #F5F5F7;
      --rich-black: #1A1A1A;
      --light-gray: #E9E8ED;

      /* Gradients */
      --gradient-primary: linear-gradient(135deg, var(--deep-purple), var(--royal-purple));
      --gradient-accent: linear-gradient(135deg, var(--coral-red), var(--electric-purple));
      --gradient-teal: linear-gradient(135deg, var(--teal), var(--electric-purple));
      --gradient-hero: linear-gradient(135deg, var(--deep-purple) 0%, var(--royal-purple) 100%);

      /* Functional Colors */
      --bg-dark: #0E0E11;
      --bg-card: rgba(245, 245, 247, 0.05);
      --text-primary: var(--off-white);
      --text-secondary: rgba(245, 245, 247, 0.8);
      --border-color: rgba(255, 255, 255, 0.1);

      /* Font */
      --font-main: 'Space Grotesk', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;

      /* Spacing */
      --radius-sm: 8px;
      --radius-md: 16px;
      --radius-lg: 24px;
      --spacing-xs: 8px;
      --spacing-sm: 16px;
      --spacing-md: 24px;
      --spacing-lg: 32px;
      --spacing-xl: 48px;
    }

    /* Reset & Base Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: var(--font-main);
      color: var(--text-primary);
      line-height: 1.6;
      padding: 0;
      margin: 0;
      overflow-x: hidden;
      position: relative;
      min-height: 100vh;
      background-color: var(--bg-dark);
      scroll-behavior: smooth;
    }

    /* Enhanced Background Effects */
    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 20% 20%, rgba(75, 45, 158, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255, 107, 107, 0.15) 0%, transparent 50%),
        linear-gradient(45deg, rgba(14, 14, 17, 0.8) 0%, rgba(14, 14, 17, 0.9) 100%);
      z-index: -1;
      animation: gradientShift 15s ease infinite alternate;
      transform: translateZ(0);
      will-change: transform, opacity;
    }

    @keyframes gradientShift {
      0% {
        background-position: 0% 0%;
        opacity: 0.8;
      }
      50% {
        background-position: 100% 100%;
        opacity: 1;
      }
      100% {
        background-position: 0% 0%;
        opacity: 0.8;
      }
    }

    .particles {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1;
      transform: translateZ(0);
      will-change: transform;
    }

    .particle {
      position: absolute;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      pointer-events: none;
      animation: float 15s infinite linear;
      transform: translateZ(0);
      will-change: transform, opacity;
    }

    @keyframes float {
      0% {
        transform: translateY(0) translateX(0) rotate(0deg) scale(1);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      90% {
        opacity: 1;
      }
      100% {
        transform: translateY(-100vh) translateX(100px) rotate(360deg) scale(0.5);
        opacity: 0;
      }
    }

    /* Add depth layers for parallax */
    .depth-layer {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -2;
      transform: translateZ(0);
      will-change: transform;
    }

    .depth-layer-1 {
      background: radial-gradient(circle at 50% 50%, rgba(75, 45, 158, 0.1) 0%, transparent 70%);
      transform: translateZ(-100px);
    }

    .depth-layer-2 {
      background: radial-gradient(circle at 30% 70%, rgba(255, 107, 107, 0.1) 0%, transparent 70%);
      transform: translateZ(-200px);
    }

    .depth-layer-3 {
      background: radial-gradient(circle at 70% 30%, rgba(0, 191, 179, 0.1) 0%, transparent 70%);
      transform: translateZ(-300px);
    }

    /* Enhanced Animations with Smoother Transitions */
    .hero-content {
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .logo {
      opacity: 0;
      transform: scale(0.8);
      animation: fadeInScale 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.3s forwards;
    }

    .hero-title-main {
      opacity: 0;
      transform: translateX(-30px);
      animation: slideInLeft 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.6s forwards;
    }

    .hero-title-sub {
      opacity: 0;
      transform: translateX(30px);
      animation: slideInRight 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.9s forwards;
    }

    .launch-counter {
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) 1.2s forwards;
    }

    .cta-form {
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) 1.5s forwards;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInScale {
      from {
        opacity: 0;
        transform: scale(0.8);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-30px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(30px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* Enhanced Feature Cards with Smoother Transitions */
    .feature-card {
      position: relative;
      overflow: hidden;
      transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
      transform-style: preserve-3d;
      perspective: 1000px;
      will-change: transform, box-shadow;
    }

    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(
        135deg,
        rgba(75, 45, 158, 0.2) 0%,
        rgba(255, 107, 107, 0.2) 100%
      );
      opacity: 0;
      transition: opacity 0.5s ease;
    }

    .feature-card:hover {
      transform: translateY(-20px) rotateX(5deg) rotateY(5deg);
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4),
                 0 0 30px rgba(123, 97, 255, 0.2);
    }

    .feature-card:hover::before {
      opacity: 1;
    }

    .feature-card-content {
      position: relative;
      z-index: 2;
      padding: 30px;
      transform: translateZ(20px);
      transition: transform 0.5s ease;
    }

    .feature-card:hover .feature-card-content {
      transform: translateZ(40px);
    }

    .feature-card-icon {
      font-size: 2.5rem;
      margin-bottom: 20px;
      color: var(--electric-purple);
      transition: all 0.5s ease;
      transform-style: preserve-3d;
    }

    .feature-card:hover .feature-card-icon {
      transform: scale(1.2) rotateY(180deg);
      color: var(--coral-red);
    }

    /* Enhanced Preview Cards */
    .preview-card {
      position: relative;
      overflow: hidden;
      transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
      transform-style: preserve-3d;
    }

    .preview-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(
        to bottom,
        rgba(0, 0, 0, 0) 0%,
        rgba(0, 0, 0, 0.4) 50%,
        rgba(0, 0, 0, 0.8) 100%
      );
      opacity: 0;
      transition: opacity 0.5s ease;
    }

    .preview-card:hover {
      transform: translateY(-15px) scale(1.05);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .preview-card:hover::before {
      opacity: 1;
    }

    .preview-card-image {
      transition: transform 0.5s ease;
    }

    .preview-card:hover .preview-card-image {
      transform: scale(1.1);
    }

    .preview-card-content {
      position: relative;
      z-index: 2;
      transform: translateZ(20px);
      transition: transform 0.5s ease;
    }

    .preview-card:hover .preview-card-content {
      transform: translateZ(40px);
    }

    /* Update section backgrounds to be transparent */
    .hero,
    .features-intro,
    .feature-section,
    .platform-preview,
    .cta-section {
      background: transparent;
      position: relative;
      isolation: isolate;
    }

    /* Add subtle hover effect to feature cards */
    .feature-card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3), 0 0 25px rgba(123, 97, 255, 0.15);
      border-color: rgba(123, 97, 255, 0.2);
      background: rgba(20, 20, 25, 0.7);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      will-change: transform;
    }

    /* Update parallax effect */
    window.addEventListener('scroll', function() {
      const scrollPosition = window.scrollY;
      const backgroundImage = document.getElementById('backgroundImage');
      const backgroundOverlay = document.getElementById('backgroundOverlay');
      
      // Smooth parallax effect with perspective
      backgroundImage.style.transform = `translateY(${scrollPosition * 0.3}px) scale(1.05) translateZ(${scrollPosition * 0.1}px)`;
      
      // Progressive blur effect
      const blurAmount = Math.min(scrollPosition / 100, 5);
      backgroundOverlay.style.backdropFilter = `blur(${blurAmount}px)`;
      backgroundOverlay.style.webkitBackdropFilter = `blur(${blurAmount}px)`;
      
      // Add subtle brightness adjustment
      backgroundImage.style.filter = `brightness(${1 - (scrollPosition * 0.0005)}) contrast(${1 + (scrollPosition * 0.0005)})`;
    });

    h1, h2, h3, h4 {
      margin-bottom: var(--spacing-sm);
      font-weight: 600;
      line-height: 1.2;
      letter-spacing: -0.02em;
    }

    h1 {
      font-size: clamp(2.5rem, 5vw, 4rem);
      font-weight: 700;
      background: var(--gradient-accent);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    h2 {
      font-size: clamp(2rem, 4vw, 3rem);
      background: var(--gradient-teal);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    h3 {
      font-size: clamp(1.5rem, 3vw, 2rem);
    }

    p {
      margin-bottom: var(--spacing-md);
      color: var(--text-secondary);
      font-size: clamp(1rem, 2vw, 1.2rem);
    }

    img {
      max-width: 100%;
      height: auto;
    }

    a {
      color: var(--teal);
      text-decoration: none;
    }

    a:hover {
      color: var(--electric-purple);
    }

    .container {
      width: 90%;
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 var(--spacing-md);
    }

    /* Hero Section - Apple/Netflix Style */
    .hero { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px; position: relative; background: transparent; }
    .hero-content { max-width: 800px; width: 100%; margin: 0 auto; text-align: center; padding: 0 20px; position: relative; z-index: 1; }
    .logo { height: 65px; margin-bottom: 40px; filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3)); transition: transform 0.3s ease; }
    .logo:hover { transform: scale(1.05); }
    .hero-title { display: flex; flex-direction: column; align-items: center; gap: 10px; margin-bottom: 40px; width: 100%; max-width: 1200px; margin-left: auto; margin-right: auto; }
    .hero-title-main { font-size: 3.2rem; line-height: 1.1; color: var(--off-white); font-weight: 600; letter-spacing: -0.02em; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); text-align: center; white-space: nowrap; }
    .hero-title-sub { font-size: 3.2rem; line-height: 1.1; background: linear-gradient(90deg, #FF6B6B 0%, #7B61FF 100%); -webkit-background-clip: text; background-clip: text; color: transparent; font-weight: 600; letter-spacing: -0.02em; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); text-align: center; white-space: nowrap; }
    .launch-counter { margin: 0 auto 40px; padding: 30px; background: rgba(20, 20, 25, 0.4); border-radius: var(--radius-lg); max-width: 500px; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .launch-counter:hover { transform: translateY(-5px); box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3); }
    .counter-label { font-size: 0.9rem; color: #00BFB3; margin-bottom: 10px; letter-spacing: 0.05em; text-transform: uppercase; font-weight: 500; }
    .counter-date { font-size: 2rem; font-weight: 600; color: #FF6B6B; margin-bottom: 25px; }
    .counter-timer { display: flex; justify-content: center; align-items: center; gap: 15px; }
    .counter-block { display: flex; flex-direction: column; align-items: center; gap: 8px; }
    .counter-value { font-size: 2.2rem; font-weight: 600; color: var(--off-white); background: rgba(30, 30, 36, 0.6); padding: 12px; min-width: 75px; border-radius: var(--radius-md); text-align: center; backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.05); }
    .counter-unit { font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500; }
    .counter-separator { font-size: 2.2rem; font-weight: 500; color: #444; margin-top: -25px; }
    .cta-form { max-width: 450px; margin: 0 auto; }
    .email-form { display: flex; margin-bottom: 15px; background: rgba(30, 30, 36, 0.4); border-radius: var(--radius-lg); overflow: hidden; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .email-form:hover { transform: translateY(-2px); box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3); }
    .email-input { flex: 1; padding: 16px 24px; border: none; background: rgba(20, 20, 25, 0.6); color: var(--off-white); font-size: 1rem; font-family: var(--font-main); }
    .email-input::placeholder { color: #666; }
    .email-input:focus { outline: none; background: rgba(20, 20, 25, 0.8); }
    .btn { padding: 16px 28px; background: linear-gradient(135deg, #FF6B6B, #FF5252); color: white; border: none; font-weight: 600; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; letter-spacing: 0.5px; }
    .btn:hover { background: linear-gradient(135deg, #FF5252, #FF6B6B); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4); }
    .offer-tag { display: inline-flex; align-items: center; justify-content: center; background: rgba(255, 107, 107, 0.1); color: #FF6B6B; padding: 10px 20px; border-radius: 100px; font-size: 0.95rem; font-weight: 500; margin: 15px auto 0; border: 1px solid rgba(255, 107, 107, 0.2); backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); }
    .offer-tag i { margin-right: 8px; font-size: 0.95rem; }

    /* Main Features Section - Netflix Style Cards */
    .features-intro { padding: 120px 0 80px; background: transparent; position: relative; text-align: center; }
    .features-intro .section-title h2 { font-size: 3.2rem; margin-bottom: 30px; background: linear-gradient(to right, var(--off-white), var(--coral-red), var(--teal)); -webkit-background-clip: text; background-clip: text; color: transparent; display: inline-block; }
    .section-title { text-align: center; margin-bottom: 60px; position: relative; }
    .section-title p { max-width: 700px; margin: 0 auto; font-size: 1.2rem; }
    .feature-section { padding: 120px 0; position: relative; background: transparent; }
    .feature-section::before { display: none; }
    .feature-section:nth-child(even) { background: transparent; }
    .feature-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; position: relative; }
    .feature-section:nth-child(even) .feature-grid { direction: rtl; }
    .feature-section:nth-child(even) .feature-content { direction: ltr; }
    .feature-content { padding: 30px; }
    .feature-title { font-size: 2.5rem; margin-bottom: 25px; color: var(--off-white); position: relative; display: inline-block; }
    .feature-title::after { content: ''; position: absolute; bottom: -10px; left: 0; width: 60px; height: 4px; background: var(--coral-red); }
    .feature-text { font-size: 1.15rem; color: var(--text-secondary); margin-bottom: 30px; line-height: 1.7; }
    .feature-points { list-style: none; margin: 0 0 30px 0; padding: 0; }
    .feature-points li { display: flex; align-items: center; margin-bottom: 15px; color: var(--text-primary); font-size: 1.1rem; }
    .feature-points li i { color: var(--coral-red); margin-right: 15px; font-size: 1.2rem; }
    .feature-section.audio-section .feature-points li i { color: var(--electric-purple); }
    .feature-section.game-section .feature-points li i { color: var(--teal); }
    .feature-section.book-section .feature-points li i { color: #FF9F1C; }
    .feature-section.live-section .feature-points li i { color: #E84855; }
    .feature-section.nft-section .feature-points li i { color: #70DDFF; }
    .feature-visual { position: relative; }
    .visual-container { position: relative; border-radius: var(--radius-lg); overflow: hidden; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4); border: 1px solid var(--border-color); transform: perspective(1000px) rotateY(-5deg); transition: all 0.5s ease; }
    .feature-section:nth-child(even) .visual-container { transform: perspective(1000px) rotateY(5deg); }
    .visual-container:hover { transform: perspective(1000px) rotateY(0) translateY(-10px); box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5); }
    .visual-container img { width: 100%; display: block; transition: all 0.5s ease; }
    .visual-container:hover img { transform: scale(1.05); }
    .visual-container::after { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.4)); z-index: 1; }
    .visual-effect { position: absolute; width: 100%; height: 100%; top: 0; left: 0; pointer-events: none; z-index: 2; }
    .visual-effect::before { content: ''; position: absolute; top: -20px; left: -20px; right: -20px; bottom: -20px; border: 2px solid rgba(255, 107, 107, 0.3); border-radius: var(--radius-lg); opacity: 0; transition: all 0.5s ease; }
    .visual-container:hover .visual-effect::before { top: 20px; left: 20px; right: 20px; bottom: 20px; opacity: 1; }
    .overlay-content { position: absolute; bottom: 0; left: 0; right: 0; padding: 30px; z-index: 3; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); }
    .overlay-content h4 { color: var(--off-white); font-size: 1.6rem; margin-bottom: 10px; }
    .overlay-content p { color: var(--text-secondary); font-size: 1rem; }
    .feature-badge { position: absolute; top: 20px; right: 20px; background: var(--coral-red); color: white; padding: 8px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; z-index: 4; box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4); }
    .feature-section.audio-section .feature-badge { background: var(--electric-purple); box-shadow: 0 5px 15px rgba(123, 97, 255, 0.4); }
    .feature-section.game-section .feature-badge { background: var(--teal); box-shadow: 0 5px 15px rgba(0, 191, 179, 0.4); }
    .feature-section.book-section .feature-badge { background: #FF9F1C; box-shadow: 0 5px 15px rgba(255, 159, 28, 0.4); }
    .feature-section.live-section .feature-badge { background: #E84855; box-shadow: 0 5px 15px rgba(232, 72, 85, 0.4); }
    .feature-section.nft-section .feature-badge { background: #70DDFF; color: var(--rich-black); box-shadow: 0 5px 15px rgba(112, 221, 255, 0.4); }

    /* Feature cards for intro section - Apple/Netflix Style */
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-top: 60px; position: relative; }
    .feature-card { background: rgba(20, 20, 25, 0.6); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border-radius: var(--radius-lg); padding: var(--spacing-lg); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2); border: 1px solid rgba(255, 255, 255, 0.1); text-align: center; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; overflow: hidden; }
    .feature-card:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3), 0 0 25px rgba(123, 97, 255, 0.15); border-color: rgba(123, 97, 255, 0.2); }
    .feature-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, var(--coral-red), var(--electric-purple)); opacity: 0.3; transition: all 0.4s ease; }
    .feature-card:nth-child(2n)::before { background: linear-gradient(90deg, var(--electric-purple), var(--teal)); }
    .feature-card:nth-child(3n)::before { background: linear-gradient(90deg, var(--teal), var(--coral-red)); }
    .feature-card:hover::before { opacity: 1; height: 6px; }
    .feature-card::after { content: ''; position: absolute; bottom: -50px; right: -50px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(123, 97, 255, 0.08), transparent 70%); opacity: 0; transition: all 0.4s ease; border-radius: 50%; }
    .feature-card:hover::after { opacity: 1; transform: scale(1.5); }
    .card-icon { width: 80px; height: 80px; background: rgba(14, 14, 17, 0.5); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--coral-red); margin: 0 auto var(--spacing-lg); position: relative; z-index: 2; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; }
    .feature-card:hover .card-icon { transform: translateY(-8px) scale(1.1); box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3); }
    .card-title { font-size: 1.4rem; margin-bottom: 15px; color: var(--off-white); font-weight: 600; letter-spacing: 0.2px; }
    .feature-card p { color: var(--text-secondary); font-size: 0.95rem; line-height: 1.6; }

    /* Platform Preview - Apple Event Style */
    .platform-preview { padding: 150px 0; background: transparent; position: relative; }
    .platform-preview::before { display: none; }
    .platform-preview .section-title { margin-bottom: 80px; }
    .platform-preview .section-title h2 { background: linear-gradient(to right, var(--teal), var(--off-white), var(--coral-red)); -webkit-background-clip: text; background-clip: text; color: transparent; display: inline-block; }
    .preview-mockup { background: rgba(20, 20, 25, 0.6); border-radius: var(--radius-lg); overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4), 0 0 40px rgba(123, 97, 255, 0.1), 0 0 20px rgba(255, 107, 107, 0.05); margin-top: 20px; transform: perspective(1000px) rotateX(2deg); position: relative; z-index: 1; transition: all 0.5s ease; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
    .preview-mockup:hover { transform: perspective(1000px) rotateX(0deg) translateY(-10px); box-shadow: 0 40px 90px rgba(0, 0, 0, 0.5), 0 0 50px rgba(123, 97, 255, 0.15), 0 0 25px rgba(255, 107, 107, 0.08); }
    .preview-header { padding: 18px 22px; background: rgba(10, 10, 12, 0.9); border-bottom: 1px solid rgba(255, 255, 255, 0.05); display: flex; align-items: center; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
    .header-controls { display: flex; gap: 8px; margin-right: 15px; }
    .control-dot { width: 12px; height: 12px; border-radius: 50%; position: relative; background: rgba(255, 107, 107, 0.7); }
    .control-dot::after { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; border-radius: 50%; background: inherit; filter: blur(2px); opacity: 0.4; z-index: -1; }
    .control-dot:nth-child(2) { background: rgba(0, 191, 179, 0.7); }
    .control-dot:nth-child(3) { background: rgba(123, 97, 255, 0.7); }
    .preview-title { font-size: 0.95rem; font-weight: 500; color: var(--text-secondary); margin-left: 10px; letter-spacing: 0.5px; }
    .preview-content { padding: 40px; position: relative; background: url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%234B2D9E" fill-opacity="0.03" fill-rule="evenodd"%3E%3Cpath d="M0 20v15h15V20H0zm10 10H5v-5h5v5zm15 0v-5h-5v5h5zm5-5h5v5h-5v-5zM20 0L0 10l10 10L0 30v10h10l10-10 10 10h10V30L30 20l10-10V0H30L20 10 10 0H0z"/%3E%3C/g%3E%3C/svg%3E'); }
    .preview-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 25px; }
    .preview-card { background: rgba(20, 20, 25, 0.5); border-radius: var(--radius-md); overflow: hidden; border: 1px solid rgba(123, 97, 255, 0.1); transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); position: relative; backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); }
    .preview-card:hover { transform: translateY(-12px) scale(1.03); box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3), 0 0 15px rgba(123, 97, 255, 0.2); border-color: rgba(123, 97, 255, 0.25); z-index: 2; }
    .preview-card-image { height: 120px; position: relative; overflow: hidden; }
    .preview-card:nth-child(1) .preview-card-image { background: linear-gradient(135deg, var(--deep-purple), var(--electric-purple)); }
    .preview-card:nth-child(2) .preview-card-image { background: linear-gradient(135deg, var(--teal), var(--electric-purple)); }
    .preview-card:nth-child(3) .preview-card-image { background: linear-gradient(135deg, var(--coral-red), var(--royal-purple)); }
    .preview-card:nth-child(4) .preview-card-image { background: linear-gradient(135deg, #FF9F1C, var(--coral-red)); }
    .preview-card:nth-child(5) .preview-card-image { background: linear-gradient(135deg, #E84855, var(--royal-purple)); }
    .preview-card:nth-child(6) .preview-card-image { background: linear-gradient(135deg, #70DDFF, var(--electric-purple)); }
    .preview-card-image::after { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.3)), url('data:image/svg+xml,%3Csvg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23FFFFFF" fill-opacity="0.1"%3E%3Cpath d="M0 0h10v10H0zM10 10h10v10H10z"/%3E%3C/g%3E%3C/svg%3E'); opacity: 0.3; transition: all 0.4s ease; }
    .preview-card:hover .preview-card-image::after { opacity: 0.15; }
    .preview-card-content { padding: 20px; position: relative; }
    .preview-card-title { font-size: 1.15rem; font-weight: 600; color: var(--off-white); margin-bottom: 8px; position: relative; display: inline-block; }
    .preview-card-title::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 40%; height: 2px; background: var(--coral-red); opacity: 0; transform: scaleX(0); transform-origin: left; transition: all 0.3s ease; }
    .preview-card:hover .preview-card-title::after { opacity: 1; transform: scaleX(1); }
    .preview-card-meta { font-size: 0.85rem; color: var(--text-secondary); display: flex; align-items: center; }
    .preview-card-meta::before { content: ''; display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: var(--coral-red); margin-right: 8px; }
    .preview-card:nth-child(2) .preview-card-meta::before { background: var(--teal); }
    .preview-card:nth-child(3) .preview-card-meta::before { background: var(--electric-purple); }
    .preview-card:nth-child(4) .preview-card-meta::before { background: #FF9F1C; }
    .preview-card:nth-child(5) .preview-card-meta::before { background: #E84855; }
    .preview-card:nth-child(6) .preview-card-meta::before { background: #70DDFF; }

    /* Final CTA Section - Apple Style */
    .cta-section { padding: 140px 0; background: transparent; position: relative; text-align: center; }
    .cta-section::before { display: none; }
    .cta-content { max-width: 700px; margin: 0 auto; position: relative; padding: 0 20px; }
    .cta-section h2 { font-size: 3.2rem; margin-bottom: 25px; background: linear-gradient(to right, var(--off-white), var(--coral-red)); -webkit-background-clip: text; background-clip: text; color: transparent; position: relative; display: inline-block; }
    .cta-section p { font-size: 1.2rem; color: var(--text-secondary); margin-bottom: 40px; line-height: 1.6; }
    .cta-section .email-form { background: rgba(14, 14, 17, 0.3); border-radius: var(--radius-lg); padding: 8px; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2); max-width: 500px; margin: 0 auto 20px; }
    .cta-section .email-input { border-radius: var(--radius-md); background: rgba(14, 14, 17, 0.4); border: 1px solid rgba(123, 97, 255, 0.1); padding: 16px 24px; font-size: 1.05rem; }
    .cta-section .btn { border-radius: var(--radius-md); padding: 16px 28px; font-size: 1.05rem; font-weight: 700; letter-spacing: 0.5px; box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3); }

    /* Footer - Apple Style */
    .footer { padding: 70px 0 50px; background: transparent; text-align: center; border-top: 1px solid var(--border-color); position: relative; }
    .footer::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(
      to bottom,
      rgba(14, 14, 17, 0.85) 0%,
      rgba(14, 14, 17, 0.8) 50%,
      rgba(14, 14, 17, 0.85) 100%
    ); z-index: -1; }
    .footer-logo { height: 50px; margin-bottom: 25px; filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3)); transition: transform 0.3s ease; }
    .footer-logo:hover { transform: scale(1.05); }
    .footer-text { margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto; position: relative; }
    .footer-text p { margin-bottom: 10px; font-size: 0.95rem; color: var(--text-secondary); }
    .social-links { display: flex; justify-content: center; flex-wrap: wrap; gap: 15px; max-width: 800px; margin: 0 auto; position: relative; }
    .social-icon { width: 44px; height: 44px; border-radius: 12px; background: rgba(46, 23, 96, 0.2); box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); position: relative; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.05); }
    .social-icon::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(225deg, rgba(75, 45, 158, 0.6), rgba(255, 107, 107, 0.2)); opacity: 0; transition: all 0.3s ease; z-index: -1; }
    .social-icon:hover { color: var(--off-white); transform: translateY(-4px) scale(1.05); box-shadow: 0 7px 20px rgba(0, 0, 0, 0.3); border-color: rgba(255, 255, 255, 0.1); }
    .social-icon:hover::before { opacity: 1; }
    .social-icon i { font-size: 1.2rem; position: relative; z-index: 1; }
    .social-links-title { display: block; margin-bottom: 20px; color: var(--off-white); font-size: 1.2rem; font-weight: 500; }

    /* Alert Messages */
    .alert { padding: 15px 20px; border-radius: var(--radius-md); margin: 20px 0; text-align: center; }
    .alert-success { background-color: rgba(0, 191, 179, 0.1); color: var(--teal); border: 1px solid rgba(0, 191, 179, 0.2); }
    .alert-danger { background-color: rgba(255, 107, 107, 0.1); color: var(--coral-red); border: 1px solid rgba(255, 107, 107, 0.2); }

    /* Animation */
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animated { animation: fadeIn 0.8s ease forwards; }
    .delay-1 { animation-delay: 0.2s; }
    .delay-2 { animation-delay: 0.4s; }
    .delay-3 { animation-delay: 0.6s; }
    .delay-4 { animation-delay: 0.8s; }

    /* Responsive */
    @media (max-width: 992px) { h1 { font-size: 3rem; } h2 { font-size: 2.2rem; } .counter-value { font-size: 2rem; min-width: 60px; padding: 10px; } .counter-separator { font-size: 2rem; } }
    @media (max-width: 768px) { h1 { font-size: 2.5rem; } h2 { font-size: 1.8rem; } .email-form { flex-direction: column; } .email-input { border-radius: var(--radius-md); margin-bottom: 10px; } .btn { border-radius: var(--radius-md); width: 100%; } .counter-timer { flex-wrap: wrap; } .counter-separator { display: none; } .counter-block { flex: 0 0 45%; margin-bottom: 20px; } }

    /* Mobile Navigation */
    .mobile-nav-toggle {
      display: none;
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1000;
      background: rgba(20, 20, 25, 0.8);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-md);
      padding: 12px;
      cursor: pointer;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      transition: all 0.3s ease;
    }

    .mobile-nav-toggle:hover {
      transform: scale(1.05);
      background: rgba(20, 20, 25, 0.9);
    }

    .mobile-nav-toggle i {
      color: var(--off-white);
      font-size: 1.5rem;
    }

    .mobile-nav {
      display: none;
      position: fixed;
      top: 0;
      right: 0;
      width: 100%;
      height: 100vh;
      background: rgba(14, 14, 17, 0.95);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      z-index: 999;
      padding: 40px;
      transform: translateX(100%);
      transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .mobile-nav.active {
      transform: translateX(0);
    }

    .mobile-nav-links {
      display: flex;
      flex-direction: column;
      gap: 20px;
      margin-top: 60px;
    }

    .mobile-nav-link {
      color: var(--off-white);
      font-size: 1.5rem;
      font-weight: 500;
      text-decoration: none;
      padding: 15px;
      border-radius: var(--radius-md);
      transition: all 0.3s ease;
    }

    .mobile-nav-link:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateX(10px);
    }

    /* Enhanced Feature Cards */
    .feature-card {
      position: relative;
      overflow: hidden;
      transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
      transform-style: preserve-3d;
      perspective: 1000px;
    }

    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(
        135deg,
        rgba(75, 45, 158, 0.2) 0%,
        rgba(255, 107, 107, 0.2) 100%
      );
      opacity: 0;
      transition: opacity 0.5s ease;
    }

    .feature-card:hover {
      transform: translateY(-20px) rotateX(5deg) rotateY(5deg);
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4),
                 0 0 30px rgba(123, 97, 255, 0.2);
    }

    .feature-card:hover::before {
      opacity: 1;
    }

    .feature-card-content {
      position: relative;
      z-index: 2;
      padding: 30px;
      transform: translateZ(20px);
      transition: transform 0.5s ease;
    }

    .feature-card:hover .feature-card-content {
      transform: translateZ(40px);
    }

    .feature-card-icon {
      font-size: 2.5rem;
      margin-bottom: 20px;
      color: var(--electric-purple);
      transition: all 0.5s ease;
      transform-style: preserve-3d;
    }

    .feature-card:hover .feature-card-icon {
      transform: scale(1.2) rotateY(180deg);
      color: var(--coral-red);
    }

    /* Enhanced Preview Cards */
    .preview-card {
      position: relative;
      overflow: hidden;
      transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
      transform-style: preserve-3d;
    }

    .preview-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(
        to bottom,
        rgba(0, 0, 0, 0) 0%,
        rgba(0, 0, 0, 0.4) 50%,
        rgba(0, 0, 0, 0.8) 100%
      );
      opacity: 0;
      transition: opacity 0.5s ease;
    }

    .preview-card:hover {
      transform: translateY(-15px) scale(1.05);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    }

    .preview-card:hover::before {
      opacity: 1;
    }

    .preview-card-image {
      transition: transform 0.5s ease;
    }

    .preview-card:hover .preview-card-image {
      transform: scale(1.1);
    }

    .preview-card-content {
      position: relative;
      z-index: 2;
      transform: translateZ(20px);
      transition: transform 0.5s ease;
    }

    .preview-card:hover .preview-card-content {
      transform: translateZ(40px);
    }

    @media (max-width: 768px) {
      .mobile-nav-toggle {
        display: block;
      }

      .hero-title-main,
      .hero-title-sub {
        font-size: 2.2rem;
        white-space: normal;
      }

      .counter-timer {
        flex-wrap: wrap;
      }

      .counter-separator {
        display: none;
      }

      .counter-block {
        flex: 0 0 45%;
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>
  <!-- Add depth layers to HTML -->
  <div class="depth-layer depth-layer-1"></div>
  <div class="depth-layer depth-layer-2"></div>
  <div class="depth-layer depth-layer-3"></div>
  <div class="particles" id="particles"></div>

  <!-- Mobile Navigation Toggle -->
  <button class="mobile-nav-toggle" id="mobileNavToggle">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Mobile Navigation Menu -->
  <nav class="mobile-nav" id="mobileNav">
    <button class="mobile-nav-toggle" id="closeNav">
      <i class="fas fa-times"></i>
    </button>
    <div class="mobile-nav-links">
      <a href="#hero" class="mobile-nav-link">Home</a>
      <a href="#features" class="mobile-nav-link">Features</a>
      <a href="#preview" class="mobile-nav-link">Preview</a>
      <a href="#cta" class="mobile-nav-link">Get Early Access</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero" id="hero">
    <div class="hero-content">
      <img src="assets/3.png" alt="Ryhze Logo" class="logo">

      <div class="hero-title">
        <div class="hero-title-main">A unified blockchain-powered platform</div>
        <div class="hero-title-sub">giving true ownership to creators</div>
      </div>

      <div class="launch-counter">
        <div class="counter-label">Launching</div>
        <div class="counter-date"><?php echo $launch_date; ?></div>

        <div class="counter-timer" id="countdown">
          <div class="counter-block">
            <div class="counter-value" id="days">00</div>
            <div class="counter-unit">Days</div>
          </div>
          <div class="counter-separator">:</div>
          <div class="counter-block">
            <div class="counter-value" id="hours">00</div>
            <div class="counter-unit">Hours</div>
          </div>
          <div class="counter-separator">:</div>
          <div class="counter-block">
            <div class="counter-value" id="minutes">00</div>
            <div class="counter-unit">Minutes</div>
          </div>
          <div class="counter-separator">:</div>
          <div class="counter-block">
            <div class="counter-value" id="seconds">00</div>
            <div class="counter-unit">Seconds</div>
          </div>
        </div>
      </div>

      <div class="cta-form">
        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success">
            <?php 
              echo $_SESSION['success'];
              unset($_SESSION['success']);
            ?>
          </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger">
            <?php 
              echo $_SESSION['error'];
              unset($_SESSION['error']);
            ?>
          </div>
        <?php endif; ?>

        <form action="" method="POST" class="email-form">
          <input type="email" name="email" placeholder="Your email address" required class="email-input">
          <button type="submit" class="btn">Get Early Access</button>
        </form>
        <div class="offer-tag">
          <i class="fas fa-gift"></i>
          First 3 months FREE + 20% off for a year
        </div>
      </div>
    </div>
  </section>

  <!-- Features Intro Section -->
  <section class="features-intro">
    <div class="container">
      <div class="section-title">
        <h2>One Platform, <span class="highlight">Unlimited Possibilities</span></h2>
        <p>Ryhze unifies all your entertainment into a single blockchain-powered platform, giving true ownership to both creators and consumers. Experience the future of digital content.</p>
      </div>

      <div class="features-grid">
        <div class="feature-card">
          <div class="card-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h3 class="card-title">True Digital Ownership</h3>
          <p>Own what you buy. Forever. All purchases and subscriptions are verified on the blockchain.</p>
        </div>

        <div class="feature-card">
          <div class="card-icon">
            <i class="fas fa-exchange-alt"></i>
          </div>
          <h3 class="card-title">Transfer & Trade</h3>
          <p>Lend, sell, or gift your digital content and subscriptions with our secure marketplace.</p>
        </div>

        <div class="feature-card">
          <div class="card-icon">
            <i class="fas fa-hand-holding-usd"></i>
          </div>
          <h3 class="card-title">Creator Economy</h3>
          <p>Creators earn more through direct payments and ongoing royalties for secondary sales.</p>
        </div>

        <div class="feature-card">
          <div class="card-icon">
            <i class="fas fa-lock"></i>
          </div>
          <h3 class="card-title">Blockchain Security</h3>
          <p>Advanced encryption ensures your digital assets remain secure with permanent ownership records.</p>
        </div>

        <div class="feature-card">
          <div class="card-icon">
            <i class="fas fa-rocket"></i>
          </div>
          <h3 class="card-title">Future-Proof Content</h3>
          <p>Your content never expires or disappears, even if platform policies change over time.</p>
        </div>

        <div class="feature-card">
          <div class="card-icon">
            <i class="fas fa-users"></i>
          </div>
          <h3 class="card-title">Community Focus</h3>
          <p>Connect directly with creators and fans through decentralized community governance.</p>
        </div>

        <div class="feature-card">
          <div class="card-icon">
            <i class="fas fa-globe"></i>
          </div>
          <h3 class="card-title">Global Access</h3>
          <p>No geographical limitations or regional restrictions for content access and sharing.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Video Feature Section -->
  <section class="feature-section video-section">
    <div class="container">
      <div class="feature-grid">
        <div class="feature-content">
          <h2 class="feature-title">Premium Video Experience</h2>
          <p class="feature-text">Stream your favorite shows, movies, and exclusive content with crystal-clear quality. Unlike traditional platforms, you truly own your subscriptions and purchased content through blockchain verification.</p>

          <ul class="feature-points">
            <li><i class="fas fa-check-circle"></i> 4K Ultra HD streaming across all devices</li>
            <li><i class="fas fa-check-circle"></i> Transferable subscriptions you can share or sell</li>
            <li><i class="fas fa-check-circle"></i> Exclusive blockchain-verified content rights</li>
            <li><i class="fas fa-check-circle"></i> Ad-free option with dedicated subscription</li>
          </ul>
        </div>

        <div class="feature-visual">
          <div class="visual-container">
            <img src="https://images.unsplash.com/photo-1616469829941-c7200edec809?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Premium Video Streaming">
            <div class="visual-effect"></div>
            <div class="feature-badge">Video</div>
            <div class="overlay-content">
              <h4>Cinematic Experience</h4>
              <p>Stream exclusive content with ownership rights secured by blockchain</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Audio Feature Section -->
  <section class="feature-section audio-section">
    <div class="container">
      <div class="feature-grid">
        <div class="feature-content">
          <h2 class="feature-title">Immersive Audio Experience</h2>
          <p class="feature-text">Stream millions of tracks in high fidelity audio. Support your favorite artists directly through our blockchain-powered royalty system that ensures fair compensation and true fan ownership.</p>

          <ul class="feature-points">
            <li><i class="fas fa-check-circle"></i> Lossless audio quality for audiophiles</li>
            <li><i class="fas fa-check-circle"></i> Direct artist support with transparent royalties</li>
            <li><i class="fas fa-check-circle"></i> Exclusive artist-to-fan experiences and content</li>
            <li><i class="fas fa-check-circle"></i> Collectible digital albums with ownership rights</li>
          </ul>
        </div>

        <div class="feature-visual">
          <div class="visual-container">
            <img src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Premium Music Streaming">
            <div class="visual-effect"></div>
            <div class="feature-badge">Audio</div>
            <div class="overlay-content">
              <h4>Sound Revolution</h4>
              <p>High-fidelity audio with fair artist compensation</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Gaming Feature Section -->
  <section class="feature-section game-section">
    <div class="container">
      <div class="feature-grid">
        <div class="feature-content">
          <h2 class="feature-title">Revolutionary Gaming Platform</h2>
          <p class="feature-text">Access hundreds of games with a single subscription. Your in-game items, character skins, and achievements are secured by blockchain, making them truly yours to keep, trade, or sell.</p>

          <ul class="feature-points">
            <li><i class="fas fa-check-circle"></i> Cloud gaming across all your devices</li>
            <li><i class="fas fa-check-circle"></i> True ownership of in-game assets and items</li>
            <li><i class="fas fa-check-circle"></i> Player-driven marketplace for trading</li>
            <li><i class="fas fa-check-circle"></i> Cross-game compatible items and currency</li>
          </ul>
        </div>

        <div class="feature-visual">
          <div class="visual-container">
            <img src="https://images.unsplash.com/photo-1560419015-7c427e8ae5ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Gaming Platform">
            <div class="visual-effect"></div>
            <div class="feature-badge">Gaming</div>
            <div class="overlay-content">
              <h4>Game Changer</h4>
              <p>Own your in-game assets and trade them in our secure marketplace</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Books Feature Section -->
  <section class="feature-section book-section">
    <div class="container">
      <div class="feature-grid">
        <div class="feature-content">
          <h2 class="feature-title">Revolutionary Reading Experience</h2>
          <p class="feature-text">Access thousands of books, magazines, and publications with true ownership. Your digital library is secured by blockchain technology, ensuring your purchases are permanently yours.</p>

          <ul class="feature-points">
            <li><i class="fas fa-check-circle"></i> Enhanced reading experience across devices</li>
            <li><i class="fas fa-check-circle"></i> Lendable digital books with sharing rights</li>
            <li><i class="fas fa-check-circle"></i> Author-direct publishing with fair royalties</li>
            <li><i class="fas fa-check-circle"></i> Limited edition digital releases with certificates</li>
          </ul>
        </div>

        <div class="feature-visual">
          <div class="visual-container">
            <img src="https://images.unsplash.com/photo-1544716278-e513176f20b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Digital Reading">
            <div class="visual-effect"></div>
            <div class="feature-badge">Books</div>
            <div class="overlay-content">
              <h4>Page Turner</h4>
              <p>Your digital library, secured forever with true ownership rights</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Live Content Feature Section -->
  <section class="feature-section live-section">
    <div class="container">
      <div class="feature-grid">
        <div class="feature-content">
          <h2 class="feature-title">Interactive Live Experiences</h2>
          <p class="feature-text">Experience concerts, events, classes, and exclusive interactive sessions with your favorite creators. All content is available for replay with blockchain-verified access rights.</p>

          <ul class="feature-points">
            <li><i class="fas fa-check-circle"></i> High-definition live streaming worldwide</li>
            <li><i class="fas fa-check-circle"></i> Interactive participation with creators</li>
            <li><i class="fas fa-check-circle"></i> Exclusive virtual meet-and-greets</li>
            <li><i class="fas fa-check-circle"></i> Perpetual access to event recordings</li>
          </ul>
        </div>

        <div class="feature-visual">
          <div class="visual-container">
            <img src="https://images.unsplash.com/photo-1576085898323-218337e3e43c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Live Content">
            <div class="visual-effect"></div>
            <div class="feature-badge">Live</div>
            <div class="overlay-content">
              <h4>Live & Interactive</h4>
              <p>Connect with creators in real-time with blockchain-verified access</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- NFT Feature Section -->
  <section class="feature-section nft-section">
    <div class="container">
      <div class="feature-grid">
        <div class="feature-content">
          <h2 class="feature-title">Digital Collectibles & NFTs</h2>
          <p class="feature-text">Collect, display, and trade digital art, memorabilia, and exclusive content from your favorite creators. All NFTs on Ryhze are verified, authenticated, and interoperable.</p>

          <ul class="feature-points">
            <li><i class="fas fa-check-circle"></i> Authenticated digital collectibles</li>
            <li><i class="fas fa-check-circle"></i> Creator-verified limited editions</li>
            <li><i class="fas fa-check-circle"></i> Integrated marketplace for buying and selling</li>
            <li><i class="fas fa-check-circle"></i> Cross-platform display and usage rights</li>
          </ul>
        </div>

        <div class="feature-visual">
          <div class="visual-container">
            <img src="https://images.unsplash.com/photo-1639762681057-408e52192e55?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="NFT Collection">
            <div class="visual-effect"></div>
            <div class="feature-badge">NFTs</div>
            <div class="overlay-content">
              <h4>Digital Collectibles</h4>
              <p>Own, display, and trade authenticated digital art and collectibles</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Platform Preview -->
  <section class="platform-preview">
    <div class="container">
      <div class="section-title">
        <h2>Experience <span class="highlight">Ryhze</span></h2>
        <p>A glimpse of what's coming on <?php echo $launch_date; ?></p>
      </div>

      <div class="preview-mockup">
        <div class="preview-header">
          <div class="header-controls">
            <span class="control-dot"></span>
            <span class="control-dot"></span>
            <span class="control-dot"></span>
          </div>
          <div class="preview-title">Ryhze Platform</div>
        </div>

        <div class="preview-content">
          <div class="preview-grid">
            <div class="preview-card">
              <div class="preview-card-image">
                <img src="glimpse/Chronos.jpg" alt="Chronos">
              </div>
              <div class="preview-card-content">
                <div class="preview-card-title">Chronos</div>
                <div class="preview-card-meta">Time Management</div>
              </div>
            </div>

            <div class="preview-card">
              <div class="preview-card-image">
                <img src="glimpse/crimson.jpg" alt="Crimson">
              </div>
              <div class="preview-card-content">
                <div class="preview-card-title">Crimson</div>
                <div class="preview-card-meta">Action Game</div>
              </div>
            </div>

            <div class="preview-card">
              <div class="preview-card-image">
                <img src="glimpse/Culinary Journeys.jpg" alt="Culinary Journeys">
              </div>
              <div class="preview-card-content">
                <div class="preview-card-title">Culinary Journeys</div>
                <div class="preview-card-meta">Cooking Series</div>
              </div>
            </div>

            <div class="preview-card">
              <div class="preview-card-image">
                <img src="glimpse/Sky Nomads.jpg" alt="Sky Nomads">
              </div>
              <div class="preview-card-content">
                <div class="preview-card-title">Sky Nomads</div>
                <div class="preview-card-meta">Adventure Game</div>
              </div>
            </div>

            <div class="preview-card">
              <div class="preview-card-image">
                <img src="glimpse/The Algorithm.jpg" alt="The Algorithm">
              </div>
              <div class="preview-card-content">
                <div class="preview-card-title">The Algorithm</div>
                <div class="preview-card-meta">Tech Series</div>
              </div>
            </div>

            <div class="preview-card">
              <div class="preview-card-image">
                <img src="glimpse/The Frontman.jpg" alt="The Frontman">
              </div>
              <div class="preview-card-content">
                <div class="preview-card-title">The Frontman</div>
                <div class="preview-card-meta">Music Series</div>
              </div>
            </div>

            <div class="preview-card">
              <div class="preview-card-image">
                <img src="glimpse/Titans Fall.jpg" alt="Titans Fall">
              </div>
              <div class="preview-card-content">
                <div class="preview-card-title">Titans Fall</div>
                <div class="preview-card-meta">Strategy Game</div>
              </div>
            </div>

            <div class="preview-card">
              <div class="preview-card-image">
                <img src="glimpse/Tournaments.jpg" alt="Tournaments">
              </div>
              <div class="preview-card-content">
                <div class="preview-card-title">Tournaments</div>
                <div class="preview-card-meta">Gaming Events</div>
              </div>
            </div>

            <div class="preview-card">
              <div class="preview-card-image">
                <img src="glimpse/Trade Winds.jpg" alt="Trade Winds">
              </div>
              <div class="preview-card-content">
                <div class="preview-card-title">Trade Winds</div>
                <div class="preview-card-meta">Trading Platform</div>
              </div>
            </div>

            <div class="preview-card">
              <div class="preview-card-image">
                <img src="glimpse/Verdant Empire The Game.jpg" alt="Verdant Empire">
              </div>
              <div class="preview-card-content">
                <div class="preview-card-title">Verdant Empire</div>
                <div class="preview-card-meta">Strategy Game</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Final CTA Section -->
  <section class="cta-section">
    <div class="container">
      <div class="cta-content">
        <h2>Be Among The First To Experience <span class="highlight">Ryhze</span></h2>
        <p>Sign up for early access before our launch on <?php echo $launch_date; ?></p>

        <div class="cta-form">
          <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
              <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
              ?>
            </div>
          <?php endif; ?>
          
          <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
              <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
              ?>
            </div>
          <?php endif; ?>

          <form action="" method="POST" class="email-form">
            <input type="email" name="email" placeholder="Your email address" required class="email-input">
            <button type="submit" class="btn">Get Early Access</button>
          </form>
          <div class="offer-tag">
            <i class="fas fa-gift"></i>
            First 3 months FREE + 20% off for a year
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <img src="assets/3.png" alt="Ryhze Logo" class="footer-logo">

      <div class="footer-text">
        <p>&copy; 2025 Ryhze. All rights reserved.</p>
        <p>A blockchain-powered unified content platform giving true ownership to creators.</p>
      </div>

      <span class="social-links-title">Follow Us</span>
      <div class="social-links">
        <a href="https://www.youtube.com/@ryhzeofficial" target="_blank" class="social-icon" title="YouTube"><i class="fab fa-youtube"></i></a>
        <a href="https://x.com/Ryhzeofficial" target="_blank" class="social-icon" title="X (Twitter)"><i class="fab fa-twitter"></i></a>
        <a href="https://www.tiktok.com/@ryhzeofficial" target="_blank" class="social-icon" title="TikTok"><i class="fab fa-tiktok"></i></a>
        <a href="https://www.instagram.com/ryhzeofficial/" target="_blank" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.twitch.tv/ryhzeofficial" target="_blank" class="social-icon" title="Twitch"><i class="fab fa-twitch"></i></a>
        <a href="https://kick.com/ryhze-official" target="_blank" class="social-icon" title="Kick"><i class="fas fa-gamepad"></i></a>
        <a href="https://www.reddit.com/user/ryhzeofficial" target="_blank" class="social-icon" title="Reddit"><i class="fab fa-reddit-alien"></i></a>
        <a href="https://www.threads.net/@ryhzeofficial" target="_blank" class="social-icon" title="Threads"><i class="fab fa-at"></i></a>
        <a href="https://www.linkedin.com/company/ryhze" target="_blank" class="social-icon" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="https://www.facebook.com/ryhzeofficial/" target="_blank" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
      </div>
    </div>
  </footer>

  <script>
    // Countdown Timer
    function updateCountdown() {
      const endDate = new Date("2025-08-08T00:00:00").getTime();
      const now = new Date().getTime();
      const timeLeft = endDate - now;

      const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
      const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

      document.getElementById("days").textContent = days < 10 ? "0" + days : days;
      document.getElementById("hours").textContent = hours < 10 ? "0" + hours : hours;
      document.getElementById("minutes").textContent = minutes < 10 ? "0" + minutes : minutes;
      document.getElementById("seconds").textContent = seconds < 10 ? "0" + seconds : seconds;
    }

    // Initial call
    updateCountdown();
    
    // Update every second
    setInterval(updateCountdown, 1000);

    // Rest of your existing code for parallax and other effects...
  </script>
</body>
</html>