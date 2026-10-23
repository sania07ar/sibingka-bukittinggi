<style>
    * {
        -webkit-tap-highlight-color: transparent;
    }

    html {
        min-height: 100%;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background-color: #f1f4f9;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    /* Hanya kunci 100vh & overflow hidden jika di layar desktop besar yang cukup tinggi */
    @media (min-width: 1024px) and (min-height: 700px) {
        html, body {
            height: 100vh;
            max-height: 100vh;
            overflow: hidden;
        }
    }

    button, a, .portal-card {
        touch-action: manipulation;
    }

    /* Ambient Glow Spheres */
    .ambient-sphere {
        position: absolute;
        border-radius: 50%;
        filter: blur(90px);
        pointer-events: none;
        opacity: 0.35;
        transition: all 0.5s ease;
    }

    /* SiMonDa Standard Orange Button */
    .btn-simonda {
        background: linear-gradient(135deg, #f95a00 0%, #eb5200 100%);
        color: #ffffff;
        font-weight: 700;
        border-radius: 0.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0.55rem 1rem;
        box-shadow: 0 4px 14px rgba(249, 90, 0, 0.25);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.25);
        cursor: pointer;
    }

    .btn-simonda:hover, .portal-card:hover .btn-simonda {
        background: linear-gradient(135deg, #ea5200 0%, #db4500 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(249, 90, 0, 0.35);
    }

    .btn-simonda:active, .portal-card:active .btn-simonda {
        transform: translateY(0) scale(0.98);
    }

    /* Slate / Indigo Button for Kelola Akun */
    .btn-account {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        font-weight: 700;
        border-radius: 0.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0.55rem 1rem;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.2);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.15);
        cursor: pointer;
    }

    .btn-account:hover, .portal-card:hover .btn-account {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.3);
    }

    .btn-account:active, .portal-card:active .btn-account {
        transform: translateY(0) scale(0.98);
    }

    /* Shimmer effect on buttons */
    .btn-simonda::after, .btn-account::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -60%;
        width: 45%;
        height: 200%;
        background: linear-gradient(
            60deg,
            rgba(255, 255, 255, 0) 20%,
            rgba(255, 255, 255, 0.3) 50%,
            rgba(255, 255, 255, 0.8) 80%
        );
        transform: rotate(25deg);
        transition: all 0.65s ease;
    }

    .btn-simonda:hover::after, .btn-account:hover::after,
    .portal-card:hover .btn-simonda::after, .portal-card:hover .btn-account::after {
        left: 130%;
    }

    /* Interactive Portal Choice Card */
    .portal-card {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        -webkit-tap-highlight-color: transparent;
    }

    .portal-card:hover {
        transform: translateY(-3px);
    }

    .portal-card:active {
        transform: scale(0.99);
    }
</style>
