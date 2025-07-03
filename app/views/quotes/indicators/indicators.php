<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Indicadores de Cotizaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Animaciones y Efectos -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #ffffff;
            color: #1e293b;
            overflow-x: hidden;
        }
        
        /* Fondo con animación de líneas */
        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.4;
            background:rgb(244, 244, 244);
        }
        
        /* Patrones gráficos sutiles */
        .pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.4;
            z-index: -1;
        }
        
        /* Animación de líneas para el encabezado */
        .header-animation {
            position: relative;
            height: 3px;
            background: linear-gradient(90deg, #f1f5f9, #94a3b8, #f1f5f9);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .header-animation::before {
            content: '';
            position: absolute;
            left: -50%;
            width: 500%;
            height: 100%;
            background: linear-gradient(90deg, transparent, #333, transparent);
            animation: headerFlowing 1s infinite linear;
        }
        
        @keyframes headerFlowing {
            0% {
                left: -50%;
            }
            100% {
                left: 150%;
            }
        }

        /* Estilo para el título */
        .title {
            font-size: 2.75rem;
            font-weight: 800;
            text-align: center;
            color: #1e293b;
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
            position: relative;
        }
        
        .title-container {
            position: relative;
            padding-bottom: 2rem;
            margin-bottom: 3rem;
        }
        
        .title-underline {
            position: relative;
            height: 4px;
            width: 180px;
            margin: 0 auto;
            background-color: #333;
            border-radius: 2px;
        }
        
        .title-underline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 25%;
            width: 50%;
            height: 100%;
            background-color: #111;
            border-radius: 2px;
            animation: pulseUnderline 2s infinite;
        }
        
        @keyframes pulseUnderline {
            0%, 100% {
                opacity: 1;
                transform: scaleX(1);
            }
            50% {
                opacity: 0.6;
                transform: scaleX(1.5);
            }
        }

        /* Contenedor de filtros mejorado */
        .filter-container {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 3rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .filter-container:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transform: translateY(-5px);
        }
        
        .filter-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #333, #60a5fa, #333);
            background-size: 200% 100%;
            animation: gradientMove 4s ease infinite;
        }
        
        @keyframes gradientMove {
            0% {
                background-position: 0% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        /* Estilo para los indicadores */
        .indicator-container {
            background: rgba(255, 255, 255, 0.5);
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 2rem;
            margin: 2rem 0 2rem 0;
        }

        .indicator {
            border: 1px solid #e2e8f0;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            margin-bottom:40px;
        }

        /* Efecto de hover para los indicadores */
        .indicator:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }
        
        /* Líneas animadas en el borde */
        .indicator::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #333, transparent);
            animation: indicatorBorderFlow 4s infinite;
        }
        
        @keyframes indicatorBorderFlow {
            0% {
                left: -100%;
            }
            50% {
                left: 100%;
            }
            100% {
                left: 100%;
            }
        }
        
        /* Estilos para contenido dentro de los indicadores */
        .indicator-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .indicator-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f1f5f9;
            border-radius: 10px;
            color: #333;
            transition: all 0.3s ease;
        }
        
        .indicator:hover .indicator-icon {
            background-color: #333;
            color: #ffffff;
            transform: rotateY(360deg);
            transition: all 0.7s ease;
        }
        
        /* Partículas flotantes sutiles */
        .particle {
            position: absolute;
            background-color: #e2e8f0;
            border-radius: 50%;
            pointer-events: none;
        }
        
        /* Líneas animadas */
        .line {
            position: absolute;
            background-color: #e2e8f0;
            pointer-events: none;
        }
        
        /* Diseño responsivo */
        @media (max-width: 1024px) {
            .indicator-container {
                grid-template-columns: 1fr;
            }
            
            .title {
                font-size: 2.25rem;
            }
        }
        
        @media (max-width: 640px) {
            .title {
                font-size: 1.75rem;
            }
            
            .filter-container, .indicator {
                padding: 1.5rem;
            }
        }
        
        /* Animaciones para los gráficos */
        .chart-container {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        .chart-visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Loader estilizado */
        .loader {
            width: 50px;
            height: 50px;
            border: 3px solid #f1f5f9;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }
        
        .loader::after {
            content: '';  
            box-sizing: border-box;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid;
            border-color: #333 transparent;
        }
        
        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
<div class="px-40 py-20">
    <!-- Fondo con animación y patrones -->
    <div class="background-animation" id="background-canvas"></div>
    <div class="pattern"></div>

    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto">

        <!-- Título general con animación -->
        <div class="title-container">
            <h1 class="title">
                <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                Cotizaciones
            </h1>
            <div class="title-underline"></div>
        </div>
        


        <!-- Filtro -->
        <div class="filter-container">
            <?php require_once 'filter.php'; ?>
        </div>

        <!-- Línea animada debajo del encabezado
        <div class="header-animation"></div> -->

        <!-- Indicadores -->
        <div class="indicator-container">

            <!-- Indicador 1 -->
            <div class="indicator" id="indicator-1">
                <h2 class="indicator-title">
                    <div class="indicator-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    Estado (Cantidad)
                </h2>
                <div class="chart-container">
                    <?php require_once 'indicator-1.php'; ?>
                </div>
            </div>

            <!-- Indicador 2 -->
            <div class="indicator" id="indicator-2">
                <h2 class="indicator-title">
                    <div class="indicator-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    Estado ($)
                </h2>
                <div class="chart-container">
                    <?php require_once 'indicator-2.php'; ?>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Inicializar animaciones y efectos
        document.addEventListener('DOMContentLoaded', function() {
            // Crear fondo animado
            createBackgroundAnimation();
            
            // Crear partículas y líneas
            createParticlesAndLines();
            
            // Inicializar observador para animaciones al hacer scroll
            initIntersectionObserver();
            
            // Inicializar tooltips y otros efectos interactivos
            initChartAnimations();
        });
        
        // Función para crear la animación de fondo usando Three.js
        function createBackgroundAnimation() {
            const canvas = document.getElementById('background-canvas');
            
            // Crear escena, cámara y renderer
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
            
            // Configurar renderer
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setClearColor(0xffffff, 0);
            canvas.appendChild(renderer.domElement);
            
            // Crear geometría de líneas
            const lines = [];
            const lineCount = 15;
            
            for (let i = 0; i < lineCount; i++) {
                const geometry = new THREE.BufferGeometry();
                const points = [];
                
                // Crear puntos para las líneas
                const segmentCount = 10;
                for (let j = 0; j < segmentCount; j++) {
                    points.push(
                        new THREE.Vector3(
                            (Math.random() - 0.5) * 20,
                            (Math.random() - 0.5) * 20,
                            (Math.random() - 0.5) * 20
                        )
                    );
                }
                
                geometry.setFromPoints(points);
                
                // Material y objeto final
                const material = new THREE.LineBasicMaterial({ 
                    color: 0xCBD5E1, 
                    transparent: true,
                    opacity: 0.5,
                    linewidth: 1 
                });
                
                const line = new THREE.Line(geometry, material);
                lines.push({
                    line: line,
                    originalPoints: [...points]
                });
                
                scene.add(line);
            }
            
            // Posicionar cámara
            camera.position.z = 15;
            
            // Función de animación
            function animate() {
                requestAnimationFrame(animate);
                
                // Animar líneas
                lines.forEach((lineObj, idx) => {
                    const line = lineObj.line;
                    const originalPoints = lineObj.originalPoints;
                    const positions = line.geometry.attributes.position.array;
                    
                    for (let i = 0; i < positions.length; i += 3) {
                        const originalX = originalPoints[i/3].x;
                        const originalY = originalPoints[i/3].y;
                        const originalZ = originalPoints[i/3].z;
                        
                        // Movimiento suave y sutil
                        positions[i] = originalX + Math.sin(Date.now() * 0.0005 + i + idx) * 0.5;
                        positions[i+1] = originalY + Math.cos(Date.now() * 0.0004 + i + idx) * 0.5;
                        positions[i+2] = originalZ;
                    }
                    
                    line.geometry.attributes.position.needsUpdate = true;
                });
                
                // Rotación muy sutil
                scene.rotation.x = Math.sin(Date.now() * 0.0001) * 0.05;
                scene.rotation.y = Math.cos(Date.now() * 0.0001) * 0.05;
                
                renderer.render(scene, camera);
            }
            
            animate();
            
            // Ajustar tamaño al redimensionar ventana
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
        }
        
        // Función para crear partículas y líneas
        function createParticlesAndLines() {
            const body = document.body;
            const particleCount = 20;
            const lineCount = 8;
            
            // Crear partículas
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Tamaño y posición aleatorios
                const size = Math.random() * 6 + 2;
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const opacity = Math.random() * 0.1 + 0.05;
                
                // Estilo
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;
                particle.style.opacity = opacity;
                
                // Animación
                particle.style.animation = `float ${Math.random() * 15 + 10}s infinite alternate ease-in-out`;
                particle.style.animationDelay = `${Math.random() * 5}s`;
                
                body.appendChild(particle);
            }
            
            // Crear líneas
            for (let i = 0; i < lineCount; i++) {
                const line = document.createElement('div');
                line.classList.add('line');
                
                // Decidir si es horizontal o vertical
                const isHorizontal = Math.random() > 0.5;
                
                if (isHorizontal) {
                    const height = Math.random() * 1 + 1;
                    const width = Math.random() * 15 + 5;
                    const posX = Math.random() * 100;
                    const posY = Math.random() * 100;
                    const opacity = Math.random() * 0.1 + 0.03;
                    
                    line.style.height = `${height}px`;
                    line.style.width = `${width}%`;
                    line.style.left = `${posX}%`;
                    line.style.top = `${posY}%`;
                    line.style.opacity = opacity;
                } else {
                    const width = Math.random() * 1 + 1;
                    const height = Math.random() * 15 + 5;
                    const posX = Math.random() * 100;
                    const posY = Math.random() * 100;
                    const opacity = Math.random() * 0.1 + 0.03;
                    
                    line.style.width = `${width}px`;
                    line.style.height = `${height}%`;
                    line.style.left = `${posX}%`;
                    line.style.top = `${posY}%`;
                    line.style.opacity = opacity;
                }
                
                // Animación
                line.style.animation = `float ${Math.random() * 20 + 15}s infinite alternate ease-in-out`;
                line.style.animationDelay = `${Math.random() * 5}s`;
                
                body.appendChild(line);
            }
        }
        
        // Observer para animar elementos cuando entran en viewport
        function initIntersectionObserver() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Animar los contenedores de gráficos cuando son visibles
                        entry.target.querySelectorAll('.chart-container').forEach(container => {
                            container.classList.add('chart-visible');
                        });
                        
                        // Dejar de observar después de animar
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });
            
            // Observar indicadores
            document.querySelectorAll('.indicator').forEach(indicator => {
                observer.observe(indicator);
            });
        }
        
        // Función para efectos adicionales en los gráficos
        function initChartAnimations() {
            // Configurar estilos globales para los gráficos
            if (window.Chart) {
                Chart.defaults.color = '#475569';
                Chart.defaults.borderColor = '#e2e8f0';
                Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";
                
                // Opcional: hooks para animaciones personalizadas
                const originalDraw = Chart.controllers.line.prototype.draw;
                Chart.controllers.line.prototype.draw = function() {
                    originalDraw.apply(this, arguments);
                    
                    // Efecto de brillo en líneas (ejemplo)
                    const ctx = this.chart.ctx;
                    ctx.save();
                    ctx.shadowColor = 'rgba(59, 130, 246, 0.5)';
                    ctx.shadowBlur = 10;
                    ctx.stroke();
                    ctx.restore();
                };
            }
        }
        
        // Animación para los elementos flotantes
        document.addEventListener('mousemove', function(e) {
            const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
            const moveY = (e.clientY - window.innerHeight / 2) * 0.01;
            
            // Movimiento sutil al mover el mouse
            document.querySelectorAll('.particle, .line').forEach(el => {
                const speed = Math.random() * 0.5;
                el.style.transform = `translate(${moveX * speed}px, ${moveY * speed}px)`;
            });
        });
    </script>
    
    <style>
        /* Animación para las partículas flotantes */
        @keyframes float {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(10px, 10px);
            }
        }
    </style>
</body>
</html>