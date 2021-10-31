(function() {
   jQuery(document).ready(function ($) {
    
        const scrollElements = document.querySelectorAll(".ebtr-container-right");

        const elementInView = (el, dividend = 1) => {
        const elementTop = el.getBoundingClientRect().top;

        return (
            elementTop <=
            (window.innerHeight || document.documentElement.clientHeight) / dividend
        );
        };

        const elementOutofView = (el) => {
        const elementTop = el.getBoundingClientRect().top;

        return (
            elementTop > (window.innerHeight || document.documentElement.clientHeight)
        );
        };

        const displayScrollElement = (element) => {
        let datadir=element.getAttribute("data-dir");
        let datatime=element.getAttribute("data-time");
        if(datadir!=''){
            datadirclass="animate__"+datadir
        }
        if(datatime!=''){
            datatimeclass="animate__delay-"+datatime
        }
        element.classList.add("animate__animated", datadirclass, datatimeclass );
        };

        const hideScrollElement = (element) => {
        //element.classList.remove("animate__animated", "animate__fadeInUp");
        };

        const handleScrollAnimation = () => {
        scrollElements.forEach((el) => {
            if (elementInView(el, 1.25)) {
            displayScrollElement(el);
            } else if (elementOutofView(el)) {
            hideScrollElement(el)
            }
        })
        }

        window.addEventListener("scroll", () => { 
        handleScrollAnimation();
        });
    })
})(jQuery)