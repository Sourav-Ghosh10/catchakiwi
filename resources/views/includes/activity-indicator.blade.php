<style>
/* Catchakiwi Global Activity Indicator Overlay */
#catchakiwi-page-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(255, 255, 255, 0.92);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999999;
    opacity: 1;
    visibility: visible;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

#catchakiwi-page-loader.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

#indicator, .catchakiwi-indicator-box {
    width: 180px;
    height: 180px;
}

#indicator svg, .catchakiwi-indicator-box svg {
    width: 100%;
    height: 100%;
    overflow: visible;
}

.person {
    opacity: 0;
    transition: opacity 180ms linear;
}

/* Form AJAX loaders styling compatibility */
#loader, .loadertwo {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 99999;
    width: 180px;
    height: 180px;
}

#loader svg, .loadertwo svg {
    width: 100%;
    height: 100%;
    overflow: visible;
}

@media print {
    #catchakiwi-page-loader {
        display: none !important;
    }
}
</style>

<div id="catchakiwi-page-loader">
    <div class="catchakiwi-indicator-box">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-200 -200 400 400">
            <defs>
                <g id="p">
                    <path fill="#5A9E16" d="M201.937,487.923c-11.376,10.978-22.025,21.262-32.684,31.537    c-16.313,15.73-32.348,31.766-49.032,47.092c-15.788,14.502-34.297,19.106-55.096,12.339c-7.403-2.409-13-7.348-17.926-13.108    c-12.81-14.984-21.973-43.985-6.071-67.953c5.099-7.684,12.125-14.123,18.493-20.923    c47.277-50.472,94.588-100.912,141.936-151.317c22.133-23.563,44.372-47.028,66.56-70.54c2.03-2.151,4.039-4.325,6.239-6.684    c-31.146-29.453-48.097-64.577-44.309-107.688c2.872-32.675,16.659-60.595,40.99-82.71c49.394-44.896,125.431-43.66,173.646,1.955    c47.171,44.627,57.522,129.345-3.045,186.439c5.735,6.17,11.458,12.375,17.231,18.531    c59.959,63.933,119.925,127.858,179.889,191.786c11.398,12.152,23.141,24.004,34.092,36.547    c10.376,11.884,13.214,26.399,10.936,41.688c-1.665,11.173-6.101,21.429-13.376,30.29c-14.19,17.285-38.378,22.285-59.234,10.803    c-8.873-4.886-16.726-12.015-24.155-19.061c-22.729-21.556-45.028-43.566-67.496-65.399c-0.597-0.58-1.182-1.176-1.811-1.721    c-4.393-3.81-7.46-2.812-8.577,2.836c-4.041,20.423-7.961,40.869-12.098,61.272c-13.832,68.226-27.8,136.425-41.598,204.657    c-13.657,67.54-27.145,135.113-40.771,202.659c-3.17,15.712-8.452,30.546-19.943,42.317    c-26.373,27.016-71.095,19.325-88.383-14.892c-7.115-14.082-9.551-29.319-12.582-44.485    c-11.973-59.914-24.045-119.809-36.052-179.716c-18.166-90.642-36.307-181.287-54.472-271.928    C202.985,491.287,202.545,490.064,201.937,487.923z" />
                </g>
            </defs>
            <g transform="rotate(0) translate(0,-112)" class="person" data-person="0"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g>
            <g transform="rotate(45) translate(0,-112)" class="person" data-person="1"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g>
            <g transform="rotate(90) translate(0,-112)" class="person" data-person="2"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g>
            <g transform="rotate(135) translate(0,-112)" class="person" data-person="3"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g>
            <g transform="rotate(180) translate(0,-112)" class="person" data-person="4"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g>
            <g transform="rotate(225) translate(0,-112)" class="person" data-person="5"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g>
            <g transform="rotate(270) translate(0,-112)" class="person" data-person="6"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g>
            <g transform="rotate(315) translate(0,-112)" class="person" data-person="7"><g transform="scale(0.045) translate(-358,-520)"><use href="#p" xlink:href="#p" /></g></g>
        </svg>
    </div>
</div>

<script>
(function() {
    function initIndicators() {
        const containers = document.querySelectorAll('.catchakiwi-indicator-box, #indicator, #loader, .loadertwo');
        containers.forEach(function(container) {
            if (container.getAttribute('data-indicator-init') === 'true') return;
            container.setAttribute('data-indicator-init', 'true');
            const people = Array.from(container.querySelectorAll('.person'));
            if (!people.length) return;
            let active = 0;
            function tick() {
                people.forEach(function(p, i) {
                    const d = (i - active + people.length) % people.length;
                    p.style.opacity =
                        d === 0 ? '1' :
                        d === 1 ? '0.55' :
                        d === 2 ? '0.18' : '0';
                });
                active = (active + 1) % people.length;
            }
            tick();
            setInterval(tick, 180);
        });
    }

    function hideGlobalLoader() {
        const pageLoader = document.getElementById('catchakiwi-page-loader');
        if (pageLoader && !pageLoader.classList.contains('hidden')) {
            pageLoader.classList.add('hidden');
            setTimeout(function() {
                pageLoader.style.display = 'none';
            }, 300);
        }
    }

    window.showCatchakiwiLoader = function() {
        const pageLoader = document.getElementById('catchakiwi-page-loader');
        if (pageLoader) {
            pageLoader.style.display = 'flex';
            pageLoader.offsetHeight; // force reflow
            pageLoader.classList.remove('hidden');
        }
    };

    window.hideCatchakiwiLoader = function() {
        hideGlobalLoader();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initIndicators();
        });
    } else {
        initIndicators();
    }

    window.addEventListener('load', function() {
        initIndicators();
        hideGlobalLoader();
    });

    // Fallback: hide loader after max 3.5 seconds if window.load is delayed
    setTimeout(function() {
        hideGlobalLoader();
    }, 3500);
})();
</script>
