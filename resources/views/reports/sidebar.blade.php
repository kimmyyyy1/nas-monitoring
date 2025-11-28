<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<button class="mobile-menu-btn" onclick="toggleSidebar()">
    ☰ MENU
</button>

<div class="sidebar" id="mySidebar">
    <div class="sidebar-header">
        <h3>NAS M&E System</h3>
        <span class="close-btn" onclick="toggleSidebar()">&times;</span>
    </div>
    
    <a href="{{ route('main.dashboard') }}" class="{{ request()->routeIs('main.dashboard') ? 'active' : '' }}">Main Dashboard</a> 
    <hr style="border-color: #444;">
    
    <a href="{{ route('reports.create') }}" class="{{ request()->routeIs('reports.create') ? 'active' : '' }}">OC-1: Learning Standards</a>
    <a href="{{ route('reports.create-retention') }}" class="{{ request()->routeIs('reports.create-retention') ? 'active' : '' }}">OC-2: Retention Rate</a>
    
    <a href="{{ route('medals.dashboard') }}" class="{{ request()->routeIs('medals.dashboard') ? 'active' : '' }}">OC-3: Medal Dashboard</a>
    <div class="submenu-container">
        <a href="{{ route('medals.national.create') }}" class="submenu-item {{ request()->routeIs('medals.national.create') ? 'active' : '' }}">
            ↳ OC-3.1: National Entry
        </a>
        <a href="{{ route('medals.international.create') }}" class="submenu-item {{ request()->routeIs('medals.international.create') ? 'active' : '' }}">
            ↳ OC-3.2: Int'l Entry
        </a>
    </div>

    <a href="{{ route('reports.create-program') }}" class="{{ request()->routeIs('reports.create-program') ? 'active' : '' }}">OP-1: Programs</a>
    <a href="{{ route('reports.create-athletes-trained') }}" class="{{ request()->routeIs('reports.create-athletes-trained') ? 'active' : '' }}">OP-2: Athletes Trained</a>
    <a href="{{ route('reports.create-facility') }}" class="{{ request()->routeIs('reports.create-facility') ? 'active' : '' }}">OP-3: Facilities</a>
    
    <hr style="border-color: #444;">
    <a href="{{ route('reports.bar-report') }}" class="{{ request()->routeIs('reports.bar-report') ? 'active' : '' }}" style="color: #ffd700;">BAR No. 1 Report</a>
</div>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<style>
    /* --- DESKTOP DEFAULTS --- */
    body { font-size: 16px; overflow-x: hidden; font-family: Arial, sans-serif; margin: 0; background-color: #f4f4f4; }
    
    /* Box Sizing Fix: Ito ang susi para hindi lumampas ang padding */
    *, *:before, *:after {
        box-sizing: border-box;
    }

    .sidebar { z-index: 1000; transition: transform 0.3s ease; }
    .submenu-container { background-color: #233342; padding: 5px 0; }
    .submenu-item { padding-left: 30px !important; font-size: 0.9em !important; border-left: 3px solid transparent; }
    .submenu-item:hover { background-color: #34495e; }
    .submenu-item.active { background-color: #34495e; color: #4db8ff !important; border-left: 3px solid #4db8ff; }
    .mobile-menu-btn, .sidebar-overlay, .close-btn { display: none; }

    /* Chart Container (Desktop) */
    .chart-container, .chart-container-wrapper, .chart-box {
        position: relative;
        width: 100%;
        height: 400px !important;
        min-height: 400px;
        max-height: 400px;
        margin-top: 15px;
    }
    canvas { display: block; width: 100% !important; height: 100% !important; }

    /* --- MOBILE RESPONSIVE STYLES (Tablets & Phones) --- */
    @media (max-width: 992px) {
        
        /* 1. LAYOUT RESET: Full Screen Width */
        .main-content {
            margin-left: 0 !important;
            padding: 60px 10px 20px 10px !important; /* Maliit na padding sa gilid para maximize space */
            width: 100% !important;
        }

        .page-container {
            flex-direction: column !important;
            display: flex !important;
            gap: 20px !important;
            width: 100% !important;
        }

        /* 2. FORM FIXES (Ito ang nag-aayos sa Form) */
        .form-column, .graph-column {
            width: 100% !important;
            min-width: 0 !important;
            padding: 15px !important; /* Sapat na padding sa loob ng card */
            margin: 0 !important;
        }

        /* I-stack lahat ng inputs vertically */
        .form-grid {
            display: flex !important;
            flex-direction: column !important;
            gap: 15px !important;
        }

        .form-group {
            width: 100% !important;
            margin-bottom: 0 !important;
        }

        /* Ayusin ang Input Fields para hindi lumampas */
        input[type="text"], 
        input[type="number"], 
        input[type="date"], 
        select, 
        textarea {
            width: 100% !important; /* Punuin ang container */
            max-width: 100% !important;
            font-size: 16px !important; /* Iwas zoom */
            padding: 12px !important;   /* Easy tap */
            height: auto !important;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* 3. CHART FIX (Mobile) */
        .chart-container, .chart-container-wrapper, .chart-box {
            height: 300px !important;
            min-height: 300px !important;
            max-height: 300px !important;
        }

        /* 4. TABLE SCROLLING */
        .table-container, .report-container {
            width: 100% !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            display: block;
            border: 1px solid #eee; /* Visual border */
        }
        
        table {
            min-width: 800px !important; /* Malapad na table para nababasa */
            width: 100% !important;
        }

        /* 5. GRID RESETS */
        .scorecard-grid, .dashboard-grid {
            grid-template-columns: 1fr !important;
            gap: 15px !important;
        }
        .span-2 { grid-column: auto !important; } /* Reset grid spans */

        /* 6. NAVIGATION UI */
        .mobile-menu-btn {
            display: block;
            position: fixed; top: 10px; left: 10px; z-index: 2000;
            background-color: #2c3e50; color: white;
            border: none; padding: 10px 15px; border-radius: 5px;
            font-size: 1.2em; box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .sidebar {
            transform: translateX(-100%);
            width: 85%; max-width: 300px;
            box-shadow: 5px 0 15px rgba(0,0,0,0.5);
        }
        .sidebar.active { transform: translateX(0); }
        
        .sidebar-header {
            display: flex; justify-content: space-between; align-items: center;
            padding-bottom: 15px; margin-bottom: 15px; border-bottom: 1px solid #555;
        }
        .close-btn { display: block; font-size: 2em; cursor: pointer; color: #fff; }

        .sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7); z-index: 999;
            backdrop-filter: blur(3px);
        }
        .sidebar-overlay.active { display: block; }

        .sticky-wrapper { position: static !important; }
        
        /* 7. FONTS & SPACING */
        h2 { font-size: 1.4em !important; line-height: 1.3; margin-top: 0; }
        h3 { font-size: 1.1em !important; margin-bottom: 10px; }
        
        .submit-button-sticky { 
            width: 100% !important;
            margin-top: 20px !important;
            margin-bottom: 50px !important; 
            padding: 15px !important;
        }
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('mySidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    document.addEventListener("DOMContentLoaded", function() {
        if (typeof Chart !== 'undefined') {
            Chart.defaults.maintainAspectRatio = false; 
            Chart.defaults.responsive = true;
        }
    });
</script>