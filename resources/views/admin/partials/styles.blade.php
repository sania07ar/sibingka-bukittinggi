<style>
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background-color: #f1f4f9;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Ambient Glow Spheres */
    .ambient-sphere {
        position: absolute;
        border-radius: 50%;
        filter: blur(90px);
        pointer-events: none;
        opacity: 0.3;
        transition: all 0.5s ease;
    }

    /* SiBingka Standard Orange Button */
    .btn-sibingka {
        background: linear-gradient(135deg, #f95a00 0%, #eb5200 100%);
        color: #ffffff;
        font-weight: 700;
        border-radius: 0.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0.6rem 1.15rem;
        box-shadow: 0 4px 14px rgba(249, 90, 0, 0.22);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
        cursor: pointer;
    }

    .btn-sibingka:hover {
        background: linear-gradient(135deg, #ea5200 0%, #db4500 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(249, 90, 0, 0.32);
    }

    .input-custom {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #1e293b;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-custom:focus {
        background-color: #ffffff;
        border-color: #f95a00;
        outline: none;
        box-shadow: 0 0 0 3px rgba(249, 90, 0, 0.14);
    }

    /* Active Tab Styling */
    .tab-btn.active {
        color: #ea580c;
        border-bottom-color: #f95a00;
        background-color: rgba(249, 90, 0, 0.05);
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 7px;
        height: 7px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
</style>
