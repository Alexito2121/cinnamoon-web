<?php
session_start();
include 'conexion.php';

// --- CONFIGURACIÓN DE USUARIO Y ROL ---
$rol = $_SESSION['rol'] ?? 'cliente';
$usuario = $_SESSION['usuario'] ?? ($_SESSION['nombre'] ?? 'Invitado');
$conteo_carrito = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;

// --- FUNCIÓN PARA MOSTRAR LAS ESTRELLAS ---
function mostrarEstrellas($rating) {
    $estrellas = ""; 
    $entero = round($rating);
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $entero) {
            $estrellas .= '<i class="fa-solid fa-star" style="color: #4C2B08;"></i>';
        } else {
            $estrellas .= '<i class="fa-regular fa-star" style="color: #ccc;"></i>';
        }
    }
    return $estrellas;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinnamoon | Inicio</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;700&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root { 
            --sky: #D0E3FF; 
            --espresso: #4C2B08; 
            --caramel: #BF7E46; 
            --milky: #FFF9F0; 
            --red: #d63031;
            --cream: #F5ECD7;
            --warm-white: #FFFCF7;
            --caramel-light: #E8A96A;
            --espresso-light: #7A4A1A;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body { 
            background: var(--warm-white); 
            font-family: 'DM Sans', sans-serif; 
            min-height: 100vh; 
            overflow-x: hidden; 
            color: var(--espresso);
        }

        /* ═══════════════════════════════
           NOISE TEXTURE OVERLAY
        ═══════════════════════════════ */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: 0.4;
        }

        /* ═══════════════════════════════
           NAVBAR
        ═══════════════════════════════ */
        .navbar { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 0 60px;
            height: 80px;
            background: rgba(255, 252, 247, 0.92); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
            position: sticky; 
            top: 0; 
            z-index: 1000; 
            border-bottom: 1px solid rgba(191, 126, 70, 0.15);
        }

        .user-info { 
            font-family: 'DM Sans', sans-serif;
            font-weight: 500; 
            color: #888;
            font-size: 14px;
            letter-spacing: 0.02em;
        }
        .user-info span { color: var(--caramel); font-weight: 700; }

        .nav-links { 
            display: flex; 
            gap: 40px; 
            align-items: center; 
        }
        .nav-links a { 
            text-decoration: none; 
            color: var(--espresso); 
            font-weight: 500; 
            font-size: 14px; 
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: color 0.3s;
            position: relative;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 1.5px;
            background: var(--caramel);
            transition: width 0.3s ease;
        }
        .nav-links a:hover { color: var(--caramel); }
        .nav-links a:hover::after { width: 100%; }

        .nav-btns { display: flex; gap: 12px; align-items: center; }

        .btn-nav-circle { 
            width: 42px; height: 42px; 
            display: flex; align-items: center; justify-content: center; 
            border-radius: 12px; 
            text-decoration: none; 
            transition: all 0.25s; 
            font-size: 16px; 
            border: 1px solid rgba(191, 126, 70, 0.25); 
            cursor: pointer;
            background: transparent;
            color: var(--espresso);
        }
        .btn-nav-circle:hover { 
            background: var(--espresso); 
            color: white; 
            border-color: var(--espresso);
            transform: translateY(-2px);
        }

        .btn-cart-main { 
            text-decoration: none; 
            padding: 11px 22px; 
            border-radius: 14px; 
            font-weight: 700; 
            font-size: 14px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            transition: all 0.3s; 
            background: var(--espresso); 
            color: white; 
            letter-spacing: 0.03em;
        }
        .btn-cart-main:hover { background: var(--caramel); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(76,43,8,0.2); }
        .badge { 
            background: var(--caramel-light); 
            color: white;
            padding: 2px 9px; 
            border-radius: 8px; 
            font-size: 11px; 
            font-weight: 800;
        }

        /* ═══════════════════════════════
           HERO
        ═══════════════════════════════ */
        .hero { 
            position: relative;
            min-height: 88vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 80px 20px 60px;
            overflow: hidden;
            background: 
                radial-gradient(ellipse 70% 60% at 20% 0%, rgba(208, 227, 255, 0.55) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 80% 100%, rgba(191, 126, 70, 0.12) 0%, transparent 60%),
                var(--warm-white);
        }

        /* Decorative arcs */
        .hero-arc {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(191, 126, 70, 0.12);
            pointer-events: none;
        }
        .hero-arc:nth-child(1) { width: 700px; height: 700px; top: 50%; left: 50%; transform: translate(-50%, -50%); }
        .hero-arc:nth-child(2) { width: 500px; height: 500px; top: 50%; left: 50%; transform: translate(-50%, -50%); border-color: rgba(191, 126, 70, 0.08); }
        .hero-arc:nth-child(3) { width: 300px; height: 300px; top: 50%; left: 50%; transform: translate(-50%, -50%); border-color: rgba(191, 126, 70, 0.06); }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(191, 126, 70, 0.1);
            border: 1px solid rgba(191, 126, 70, 0.25);
            color: var(--caramel);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 7px 16px;
            border-radius: 50px;
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
            animation: fadeSlideDown 0.8s ease both;
        }
        .hero-tag::before {
            content: '';
            width: 6px; height: 6px;
            background: var(--caramel);
            border-radius: 50%;
        }

        .main-logo { 
            position: relative; 
            z-index: 2; 
            width: 200px; 
            filter: drop-shadow(0 25px 40px rgba(76, 43, 8, 0.18)); 
            transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: fadeSlideDown 0.9s ease 0.1s both;
        }
        .main-logo:hover { transform: scale(1.08) rotate(-4deg); }

        .brand { 
            position: relative; 
            z-index: 2; 
            font-family: 'Pacifico', cursive; 
            color: var(--espresso); 
            font-size: 6.5rem; 
            margin: 5px 0 0; 
            line-height: 1;
            animation: fadeSlideDown 1s ease 0.2s both;
        }
        .brand-sub {
            position: relative;
            z-index: 2;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1.4rem;
            color: var(--caramel);
            letter-spacing: 0.1em;
            margin-top: 8px;
            animation: fadeSlideDown 1.1s ease 0.3s both;
        }

        .hero-cta {
            position: relative;
            z-index: 2;
            margin-top: 40px;
            display: flex;
            gap: 14px;
            animation: fadeSlideDown 1.2s ease 0.4s both;
        }
        .cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 32px;
            background: var(--espresso);
            color: white;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s;
            letter-spacing: 0.02em;
        }
        .cta-primary:hover { background: var(--caramel); transform: translateY(-3px); box-shadow: 0 12px 30px rgba(76,43,8,0.2); }
        .cta-secondary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 32px;
            background: transparent;
            color: var(--espresso);
            text-decoration: none;
            border-radius: 16px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
            border: 1.5px solid rgba(76,43,8,0.2);
        }
        .cta-secondary:hover { border-color: var(--caramel); color: var(--caramel); transform: translateY(-3px); }

        /* Scroll indicator */
        .scroll-hint {
            position: absolute;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            z-index: 2;
            animation: fadeSlideDown 1.4s ease 0.6s both;
        }
        .scroll-hint span {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(76,43,8,0.4);
        }
        .scroll-line {
            width: 1px;
            height: 50px;
            background: linear-gradient(to bottom, var(--caramel), transparent);
            animation: scrollPulse 2s ease-in-out infinite;
        }
        @keyframes scrollPulse {
            0%, 100% { opacity: 0.3; transform: scaleY(0.8); }
            50% { opacity: 1; transform: scaleY(1); }
        }

        
        /* ═══════════════════════════════
           STATS STRIP
        ═══════════════════════════════ */
        .stats-strip {
            background: var(--espresso);
            padding: 30px 60px;
            display: flex;
            justify-content: center;
            gap: 80px;
        }
        .stat-item {
            text-align: center;
            color: white;
        }
        .stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 600;
            color: var(--caramel-light);
            line-height: 1;
        }
        .stat-label {
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            margin-top: 4px;
        }

        /* ═══════════════════════════════
           SECTIONS
        ═══════════════════════════════ */
        section { 
            padding: 100px 40px; 
            max-width: 1300px; 
            margin: 0 auto; 
        }

        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 60px;
            gap: 20px;
        }
        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--caramel);
            margin-bottom: 10px;
        }
        .section-title h2 { 
            font-family: 'Cormorant Garamond', serif; 
            color: var(--espresso); 
            font-size: 3.5rem; 
            font-weight: 600;
            line-height: 1.1;
        }
        .section-header-line {
            flex: 1;
            max-width: 200px;
            height: 1px;
            background: linear-gradient(to right, rgba(191,126,70,0.4), transparent);
            margin-bottom: 8px;
        }

        /* ═══════════════════════════════
           PRODUCT GRID
        ═══════════════════════════════ */
        .grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(310px, 1fr)); 
            gap: 28px; 
        }

        .card { 
            background: var(--milky);
            border-radius: 28px; 
            padding: 0;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            text-align: center; 
            display: flex; 
            flex-direction: column; 
            position: relative; 
            border: 1px solid rgba(191, 126, 70, 0.1);
            overflow: hidden;
        }
        .card:hover { 
            transform: translateY(-12px); 
            box-shadow: 0 30px 60px rgba(76, 43, 8, 0.1);
            border-color: rgba(191, 126, 70, 0.25);
        }

        .card-image-wrap {
            position: relative;
            overflow: hidden;
        }
        .card img { 
            width: 100%; 
            height: 260px; 
            object-fit: cover; 
            display: block;
            transition: transform 0.5s ease;
        }
        .card:hover img { transform: scale(1.04); }

        .card-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(76,43,8,0.15) 0%, transparent 50%);
        }

        .stock-info { 
            position: absolute; 
            top: 16px; 
            right: 16px; 
            padding: 5px 13px; 
            border-radius: 30px; 
            font-size: 11px; 
            font-weight: 700; 
            letter-spacing: 0.05em;
            z-index: 5; 
        }
        .stock-ok { background: rgba(85, 239, 196, 0.9); color: #008f68; backdrop-filter: blur(4px); }
        .stock-low { background: var(--caramel); color: white; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }

        .card-body {
            padding: 22px 24px 24px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.55rem;
            font-weight: 600;
            color: var(--espresso);
            margin-bottom: 6px;
            line-height: 1.2;
        }

        .rating { margin-bottom: 14px; }
        .rating i { font-size: 13px; }

        .mini-resena { 
            font-size: 12px; 
            color: #666; 
            margin-bottom: 14px;
            text-align: left; 
            background: white; 
            padding: 12px 14px; 
            border-radius: 14px; 
            border-left: 3px solid var(--caramel);
            cursor: pointer; 
            transition: all 0.3s;
            line-height: 1.5;
        }
        .mini-resena:hover { 
            background: var(--sky); 
            transform: translateX(4px); 
        }
        
        .btn-escribir { 
            background: none; 
            border: none; 
            color: var(--caramel); 
            font-size: 11px; 
            font-weight: 700; 
            cursor: pointer; 
            margin-bottom: 16px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-decoration: none;
            font-family: 'DM Sans', sans-serif;
            transition: opacity 0.2s;
        }
        .btn-escribir:hover { opacity: 0.7; }

        .card-price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .price { 
            font-family: 'Cormorant Garamond', serif;
            color: var(--espresso); 
            font-weight: 600; 
            font-size: 2rem; 
            line-height: 1;
        }
        .price-label {
            font-size: 11px;
            color: #aaa;
            letter-spacing: 0.08em;
            font-weight: 500;
        }

        .add-row {
            display: flex; 
            gap: 10px;
        }
        .qty-input {
            width: 65px; 
            border-radius: 14px; 
            border: 1.5px solid rgba(191, 126, 70, 0.25); 
            background: white;
            text-align: center; 
            font-weight: 700; 
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            color: var(--espresso);
            outline: none;
            transition: border-color 0.2s;
        }
        .qty-input:focus { border-color: var(--caramel); }

        .btn-add { 
            flex: 1;
            background: var(--espresso); 
            color: white; 
            border: none; 
            padding: 14px; 
            border-radius: 14px; 
            font-weight: 700; 
            font-size: 14px;
            cursor: pointer; 
            transition: all 0.3s; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 8px;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.02em;
        }
        .btn-add:hover:not(:disabled) { background: var(--caramel); }
        .btn-add:disabled { opacity: 0.45; cursor: not-allowed; }

        .admin-bar {
            display: flex;
            justify-content: center;
            gap: 24px;
            border-top: 1px solid rgba(76, 43, 8, 0.08);
            padding: 14px 24px;
            background: rgba(76,43,8,0.02);
        }
        .admin-bar a {
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: opacity 0.2s;
        }
        .admin-bar a:hover { opacity: 0.6; }

        /* ═══════════════════════════════
           SOBRE NOSOTROS
        ═══════════════════════════════ */
        .about-wrap {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            background: var(--milky);
            border-radius: 40px;
            overflow: hidden;
            border: 1px solid rgba(191, 126, 70, 0.1);
        }
        .about-image-side {
            position: relative;
            min-height: 550px;
        }
        .about-image-side img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .about-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(76,43,8,0.1) 0%, transparent 60%);
        }
        .about-badge {
            position: absolute;
            bottom: 30px;
            right: -20px;
            background: var(--espresso);
            color: white;
            padding: 20px 28px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(76,43,8,0.25);
        }
        .about-badge-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.8rem;
            font-weight: 600;
            color: var(--caramel-light);
            line-height: 1;
        }
        .about-badge-label {
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.6);
        }

        .about-content-side {
            padding: 60px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .about-content-side h3 { 
            font-family: 'Cormorant Garamond', serif; 
            color: var(--espresso); 
            font-size: 2.8rem;
            font-weight: 600;
            line-height: 1.15;
            margin-bottom: 24px; 
        }
        .about-content-side h3 em {
            color: var(--caramel);
            font-style: italic;
        }
        .about-content-side p { 
            line-height: 1.85; 
            color: #666; 
            font-size: 1rem;
            margin-bottom: 14px;
        }
        .features { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 16px; 
            margin-top: 30px; 
        }
        .feat-item { 
            font-weight: 600; 
            color: var(--espresso); 
            display: flex; 
            align-items: center; 
            gap: 10px;
            font-size: 14px;
        }
        .feat-icon {
            width: 36px;
            height: 36px;
            background: rgba(191, 126, 70, 0.12);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .feat-item i { color: var(--caramel); font-size: 14px; }

        /* ═══════════════════════════════
           CONTACTO
        ═══════════════════════════════ */
        .contact-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); 
            gap: 24px; 
        }
        .contact-card { 
            background: var(--milky); 
            padding: 44px 36px; 
            border-radius: 28px; 
            text-align: center; 
            transition: all 0.35s; 
            border: 1px solid rgba(191, 126, 70, 0.1);
            position: relative;
            overflow: hidden;
        }
        .contact-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(to right, var(--caramel), var(--caramel-light));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }
        .contact-card:hover { 
            transform: translateY(-8px); 
            background: white; 
            box-shadow: 0 20px 45px rgba(76,43,8,0.08);
        }
        .contact-card:hover::before { transform: scaleX(1); }
        .contact-icon {
            width: 60px;
            height: 60px;
            background: rgba(191, 126, 70, 0.1);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.5rem;
            color: var(--caramel);
            transition: all 0.3s;
        }
        .contact-card:hover .contact-icon {
            background: var(--espresso);
            color: white;
        }
        .contact-card h4 { 
            font-family: 'Cormorant Garamond', serif;
            margin-bottom: 8px; 
            color: var(--espresso); 
            font-size: 1.4rem; 
            font-weight: 600;
        }
        .contact-card p { color: #888; font-size: 0.95rem; }

        /* ═══════════════════════════════
           FOOTER
        ═══════════════════════════════ */
        footer { 
            background: var(--espresso); 
            color: white; 
            padding: 70px 60px 40px;
            position: relative;
            overflow: hidden;
        }
        footer::before {
            content: 'Cinnamoon';
            position: absolute;
            font-family: 'Pacifico', cursive;
            font-size: 14rem;
            color: rgba(255,255,255,0.03);
            bottom: -30px;
            left: -20px;
            pointer-events: none;
            line-height: 1;
        }
        .footer-inner {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
        }
        .footer-brand { font-family: 'Pacifico', cursive; font-size: 2.2rem; color: var(--caramel-light); }
        .footer-copy { font-size: 13px; color: rgba(255,255,255,0.4); letter-spacing: 0.04em; }
        .footer-links { display: flex; gap: 28px; }
        .footer-links a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 13px; transition: color 0.2s; }
        .footer-links a:hover { color: var(--caramel-light); }

        /* FLOAT BTN */
        .float-btn { 
            position: fixed; 
            bottom: 32px; 
            right: 32px; 
            width: 60px; height: 60px; 
            background: var(--espresso); 
            color: white; 
            border-radius: 18px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 22px; 
            z-index: 1001; 
            text-decoration: none; 
            box-shadow: 0 10px 30px rgba(76, 43, 8, 0.3); 
            transition: all 0.3s; 
        }
        .float-btn:hover { transform: scale(1.1) rotate(90deg); background: var(--caramel); }

        /* ═══════════════════════════════
           ANIMATIONS
        ═══════════════════════════════ */
        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ═══════════════════════════════
           RESPONSIVE
        ═══════════════════════════════ */
        @media (max-width: 900px) {
            .navbar { padding: 0 24px; }
            .nav-links { display: none; }
            .brand { font-size: 4rem; }
            .about-wrap { grid-template-columns: 1fr; }
            .about-image-side { min-height: 320px; }
            .about-content-side { padding: 40px 30px; }
            .stats-strip { gap: 40px; padding: 24px 30px; flex-wrap: wrap; }
            section { padding: 70px 24px; }
            .section-header { flex-direction: column; align-items: flex-start; }
            .footer-inner { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div class="user-info">Hola, <span><?php echo htmlspecialchars($usuario); ?></span> 👋</div>
        <div class="nav-links">
            <a href="#inicio">Inicio</a>
            <a href="#productos">Productos</a>
            <a href="#nosotros">Nosotros</a>
            <a href="#contacto">Contacto</a>
        </div>
        <div class="nav-btns">
            <a href="logout_cliente.php" class="btn-nav-circle" title="Cerrar sesión"><i class="fa-solid fa-door-open"></i></a>
            <button onclick="checkAdmin()" class="btn-nav-circle" style="color:#bbb;"><i class="fa-solid fa-ellipsis-vertical"></i></button>
            <a href="ver_carrito.php" class="btn-cart-main">
                <i class="fa-solid fa-basket-shopping"></i> <span class="badge"><?php echo $conteo_carrito; ?></span>
            </a>
        </div>
    </div>

    <!-- HERO -->
    <header id="inicio" class="hero">
        <div class="hero-arc"></div>
        <div class="hero-arc"></div>
        <div class="hero-arc"></div>

        <div class="hero-tag">Repostería Artesanal · Santo Domingo</div>
        <img src="IMALOGO-removebg-preview.png" alt="Logo Cinnamoon" class="main-logo">
        <h1 class="brand">Cinnamoon</h1>
        <p class="brand-sub">Dulces que cuentan historias</p>
        <div class="hero-cta">
            <a href="#productos" class="cta-primary"><i class="fa-solid fa-cookie-bite"></i> Ver Productos</a>
            <a href="#nosotros" class="cta-secondary">Nuestra Historia</a>
        </div>
        <div class="scroll-hint">
            <span>Explorar</span>
            <div class="scroll-line"></div>
        </div>
    </header>

    <!-- STATS STRIP -->
    <div class="stats-strip">
        <div class="stat-item">
            <div class="stat-num">100%</div>
            <div class="stat-label">Artesanal</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">★ 5.0</div>
            <div class="stat-label">Calificación</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">Fresh</div>
            <div class="stat-label">Siempre del día</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">♡</div>
            <div class="stat-label">Hecho con amor</div>
        </div>
    </div>

    <!-- PRODUCTOS -->
    <section id="productos">
        <div class="section-header reveal">
            <div class="section-title">
                <div class="section-label">· Menú ·</div>
                <h2>Nuestra Vitrina</h2>
            </div>
            <div class="section-header-line"></div>
        </div>

        <div class="grid">
            <?php
            $res = mysqli_query($conexion, "SELECT * FROM productos ORDER BY id DESC");
            while($p = mysqli_fetch_assoc($res)): 
                $id_p = $p['id'];
                $stock = $p['stock'] ?? 0;
                $q_resena = mysqli_query($conexion, "SELECT AVG(estrellas) as prom FROM reseñas WHERE id_producto = $id_p");
                $prom = mysqli_fetch_assoc($q_resena)['prom'] ?? 0;
            ?>
            <div class="card reveal">
                <div class="card-image-wrap">
                    <div class="stock-info <?php echo ($stock <= 5) ? 'stock-low' : 'stock-ok'; ?>">
                        <?php echo ($stock > 0) ? "Quedan: $stock" : "AGOTADO"; ?>
                    </div>
                    <img src="<?php echo $p['imagen']; ?>" alt="<?php echo htmlspecialchars($p['nombre']); ?>">
                    <div class="card-image-overlay"></div>
                </div>

                <div class="card-body">
                    <h3 class="card-name"><?php echo $p['nombre']; ?></h3>
                    <div class="rating"><?php echo mostrarEstrellas($prom); ?></div>

                    <div class="mini-resena" onclick="window.location.href='ver_resenas.php?id=<?php echo $id_p; ?>'">
                        <?php
                        $ult = mysqli_query($conexion, "SELECT usuario, comentario FROM reseñas WHERE id_producto = $id_p ORDER BY fecha DESC LIMIT 1");
                        if($r = mysqli_fetch_assoc($ult)) { 
                            echo "<b>" . htmlspecialchars($r['usuario']) . ":</b> \"" . substr(htmlspecialchars($r['comentario']), 0, 45) . "...\""; 
                        } else { 
                            echo "<i>Sé el primero en opinar...</i>"; 
                        }
                        ?>
                    </div>

                    <button class="btn-escribir" onclick="nuevaResena(<?php echo $id_p; ?>, '<?php echo $p['nombre']; ?>')">
                        <i class="fa-regular fa-pen-to-square"></i> Escribir reseña
                    </button>

                    <div class="card-price-row">
                        <div>
                            <div class="price-label">Precio</div>
                            <span class="price">RD$ <?php echo number_format($p['precio'], 0); ?></span>
                        </div>
                    </div>

                    <div class="add-row">
                        <input type="number" id="cant_<?php echo $id_p; ?>" value="1" min="1" max="<?php echo $stock; ?>" class="qty-input">
                        <button class="btn-add" onclick="alCarrito(<?php echo $id_p; ?>)" <?php echo ($stock <= 0) ? 'disabled' : ''; ?>>
                            <i class="fa-solid fa-plus"></i> <?php echo ($stock > 0) ? 'Añadir' : 'Agotado'; ?>
                        </button>
                    </div>
                </div>

                <?php if($rol === 'admin'): ?>
                    <div class="admin-bar">
                        <a href="editar_producto.php?id=<?php echo $id_p; ?>" style="color:#0984e3;"><i class="fa-solid fa-pen"></i> Editar</a>
                        <a href="eliminar_producto.php?id=<?php echo $id_p; ?>" style="color:var(--red);" onclick="return confirm('¿Borrar producto?')"><i class="fa-solid fa-trash"></i> Eliminar</a>
                    </div>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- NOSOTROS -->
    <section id="nosotros">
        <div class="section-header reveal">
            <div class="section-title">
                <div class="section-label">· Historia ·</div>
                <h2>Sobre Nosotros</h2>
            </div>
            <div class="section-header-line"></div>
        </div>
        <div class="about-wrap reveal">
            <div class="about-image-side">
                <img src="Gemini_Generated_Image_w08yilw08yilw08y.png" alt="Nosotros">
                <div class="about-image-overlay"></div>
                <div class="about-badge">
                    <div class="about-badge-num">100%</div>
                    <div class="about-badge-label">Artesanal</div>
                </div>
            </div>
            <div class="about-content-side">
                <div class="section-label">· Nuestra Dulce Historia ·</div>
                <h3>Cada postre,<br><em>una historia</em></h3>
                <p>En <b>Cinnamoon</b>, creemos que cada postre cuenta una historia. Lo que comenzó en una cocina familiar se ha convertido en un rincón de felicidad para todos nuestros clientes.</p>
                <p>Nuestra misión es ofrecerte repostería 100% artesanal, utilizando solo ingredientes de la más alta calidad para garantizar un sabor inolvidable en cada mordida.</p>
                <div class="features">
                    <div class="feat-item">
                        <div class="feat-icon"><i class="fa-solid fa-star"></i></div>
                        Calidad Premium
                    </div>
                    <div class="feat-item">
                        <div class="feat-icon"><i class="fa-solid fa-leaf"></i></div>
                        Ingredientes Naturales
                    </div>
                    <div class="feat-item">
                        <div class="feat-icon"><i class="fa-solid fa-heart"></i></div>
                        Hecho a Mano
                    </div>
                    <div class="feat-item">
                        <div class="feat-icon"><i class="fa-solid fa-clock"></i></div>
                        Siempre Fresco
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACTO -->
    <section id="contacto">
        <div class="section-header reveal">
            <div class="section-title">
                <div class="section-label">· Encuéntranos ·</div>
                <h2>Contacto</h2>
            </div>
            <div class="section-header-line"></div>
        </div>
        <div class="contact-grid">
            <div class="contact-card reveal">
                <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
                <h4>Ubicación</h4>
                <p>Santo Domingo, Rep. Dom.</p>
            </div>
            <div class="contact-card reveal">
                <div class="contact-icon"><i class="fa-brands fa-whatsapp"></i></div>
                <h4>WhatsApp</h4>
                <p>+1 (829) 287-2112</p>
            </div>
            <div class="contact-card reveal">
                <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                <h4>Email</h4>
                <p>hola@cinnamoon.com</p>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-inner">
            <div class="footer-brand">Cinnamoon</div>
            <div class="footer-links">
                <a href="#inicio">Inicio</a>
                <a href="#productos">Productos</a>
                <a href="#nosotros">Nosotros</a>
                <a href="#contacto">Contacto</a>
            </div>
            <div class="footer-copy">&copy; 2026 · Hecho con amor por Uriel Salazar</div>
        </div>
    </footer>

    <!-- FLOAT BTN (ADMIN) -->
    <?php if ($rol === 'admin'): ?>
        <a href="nuevo_producto.php" class="float-btn" title="Añadir producto"><i class="fa-solid fa-plus"></i></a>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ── Todas las funciones originales intactas ──
        function checkAdmin() {
            Swal.fire({
                title: 'PIN de Acceso',
                input: 'password',
                confirmButtonColor: '#4C2B08',
                showCancelButton: true
            }).then((result) => {
                if (result.value === 'alex1121') { window.location.href = 'index.php'; }
            });
        }
        function alCarrito(id) {
            var cant = document.getElementById('cant_'+id).value;
            window.location.href = 'carrito_accion.php?id=' + id + '&cantidad=' + cant;
        }
        function nuevaResena(idProducto, nombreProducto) {
            Swal.fire({
                title: 'Opina sobre ' + nombreProducto,
                html: '<select id="swal-estrellas" class="swal2-input"><option value="5">⭐⭐⭐⭐⭐</option><option value="4">⭐⭐⭐⭐</option><option value="3">⭐⭐⭐</option><option value="2">⭐⭐</option><option value="1">⭐</option></select><textarea id="swal-comentario" class="swal2-textarea" placeholder="Tu mensaje..."></textarea>',
                confirmButtonColor: '#4C2B08',
                preConfirm: () => {
                    return { estrellas: document.getElementById('swal-estrellas').value, comentario: document.getElementById('swal-comentario').value }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `guardar_resena.php?id_p=${idProducto}&estrellas=${result.value.estrellas}&comentario=${encodeURIComponent(result.value.comentario)}`;
                }
            });
        }

        // ── Scroll reveal ──
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 80);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        revealEls.forEach(el => observer.observe(el));
    </script>
</body>
</html>