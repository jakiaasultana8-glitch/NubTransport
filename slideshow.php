<div class="slideshow-container">
    <div class="mySlides">
        <img src="../images/img1.jpg" alt="Company Office">
    </div>
    <div class="mySlides">
        <img src="../images/img2.jpg" alt="Luxury Bus">
    </div>
    <div class="mySlides">
        <img src="../images/img3.jpg" alt="Modern Bus">
    </div>
    <div class="mySlides">
        <img src="../images/img4.jpg" alt="Our Team">
    </div>
    <div class="mySlides">
        <img src="../images/img5.jpg" alt="Our Team">
    </div>
    <div class="mySlides">
        <img src="../images/img6.jpg" alt="Our Team">
    </div>
    <div class="mySlides">
        <img src="../images/img7.jpg" alt="Our Team">
    </div>

    <!-- Next and previous buttons -->
    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>
</div>

<!-- The dots -->
<div class="dot-container">
    <span class="dot" onclick="currentSlide(1)"></span> 
    <span class="dot" onclick="currentSlide(2)"></span> 
    <span class="dot" onclick="currentSlide(3)"></span> 
    <span class="dot" onclick="currentSlide(4)"></span>
    <span class="dot" onclick="currentSlide(5)"></span> 
    <span class="dot" onclick="currentSlide(6)"></span> 
    <span class="dot" onclick="currentSlide(7)"></span>   
</div>

<style>
.slideshow-container {
    max-width: 1000px;
    position: relative;
    margin: 30px auto;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}
.mySlides { display: none; }
.mySlides img { width: 100%; height: 450px; object-fit: cover; }

.prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 22px;
    transition: 0.3s;
    border-radius: 50%;
    user-select: none;
    background: rgba(0,0,0,0.4);
}
.next { right: 10px; }
.prev { left: 10px; }
.prev:hover, .next:hover { background: rgba(0,0,0,0.8); }

.dot-container { text-align: center; margin-top: 10px; }
.dot {
    height: 12px; width: 12px;
    margin: 0 5px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    cursor: pointer;
}
.active { background-color: #333; }
</style>

<script>
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}
function currentSlide(n) {
    showSlides(slideIndex = n);
}
function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
}
// Auto slideshow
setInterval(() => { plusSlides(1); }, 4000);
</script>

