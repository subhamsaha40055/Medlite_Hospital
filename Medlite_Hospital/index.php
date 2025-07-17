<?php
/*$category = $_POST['category'];
echo "category: " . $category;*/

$conn = mysqli_connect('localhost','root','','Medlite_Hospital') or die('connection failed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
    <title>Medlite Hospital</title>
  </head>
  <body>
    <header>
      <nav class="section__container nav__container">
        <div class="nav__logo"><img src="logo2.png" id="nav_image"></div>
        <ul class="nav__links">
         <li class="link"><a href="#home">Home</a></li>
          <li class="link"><a href="#about">About Us</a></li>
          <li class="link"><a href="#service">Services</a></li>
          <li class="link"><a href="#Doctors">Doctors</a></li>
          <li class="link"><a href="#information">Info</a></li>
        </ul>
        <button class="btn con"><a href="#footer__col">Contact Us</a></button>
      </nav>
      <div class="section__container header__container" id="home">
        <div class="header__content">
          <h1>Welcome to <span>Medlite Hospital,</span> Where a New Journey of Care and Trust Begins.</h1>
          <p>
            Welcome, where your health and comfort come first. With expert care, advanced technology, and a commitment to personalized service, we’re here to support your journey to wellness. Trust us to provide compassionate care and make a meaningful difference in your health experience.
          </p>
          <button class="btn">see services <a href="#service__header"></a></button>
        </div>
        <div class="header__form">
           <form action="login.php" method="POST">
             <h4>Login</h4>
              <input type="text" name="email"  placeholder="Email Address" required />
              <input type="password" name="password"  placeholder="Password" required />
              <select name="usertype" id="category" required>
                <option id="who" >Who are you?</option>
                <option value="p" id="col">Patient</option>
                <option value="d" id="col">Doctor</option>
                <option value="ad" id="col">Admin</option>
              </select>
              <button type="submit" class="btn form__btn" name="patsub">Login</button>
              <button class="btn form__btn2"><a href="signup.php">Sign Up</a></button>
            </form>
        </div>

    </header>

    <section class="section__container service__container" id="service">
      <div class="service__header">
        <div class="service__header__content">
          <h2 class="section__header">Our Special service</h2>
          <p>
            Beyond simply providing medical care, our commitment lies in
            delivering unparalleled service tailored to your unique needs.
          </p>
        </div>
        <button class="service__btn">Ask A Service</button>
      </div>
      <div class="service__grid">
        <div class="service__card">
          <span><i class="ri-microscope-line"></i></span>
          <h4>Laboratory Test</h4>
          <p>
            Accurate Diagnostics, Swift Results: Experience top-notch Laboratory
            Testing at our facility.
          </p>
          <a href="#">Learn More</a>
        </div>
        <div class="service__card">
          <span><i class="ri-mental-health-line"></i></span>
          <h4>Health Check</h4>
          <p>
            Our thorough assessments and expert evaluations help you stay
            proactive about your health.
          </p>
          <a href="#">Learn More</a>
        </div>
        <div class="service__card">
          <span><i class="ri-hospital-line"></i></span>
          <h4>General Dentistry</h4>
          <p>
            Experience comprehensive oral care with Dentistry. Trust us to keep
            your smile healthy and bright.
          </p>
          <a href="#">Learn More</a>
        </div>
      </div>
    </section>
    <section class="section__container about__container" id="about">
      <div class="about__content">
        <h2 class="section__header">About Us</h2>
        <p>
        Welcome to MedLite Hospital, where compassionate care meets modern healthcare excellence. We’re more than just a hospital—we’re your partner on the journey to better health and well-being.  
        </p>
        <p> At MedLite, we combine cutting-edge medical expertise with a patient-centered approach, offering personalized care and guidance for every stage of life. From routine check-ups to specialized treatments, our dedicated team is here to ensure you feel empowered and supported at every step. 
        </p>
        <p>Explore our wellness resources and expert tips to help you live a healthier, more balanced life. At MedLite Hospital, we believe in not just healing but inspiring healthier, happier futures for all.
        </p>
      </div>
      <div class="about__image">
        <img src="Logo banner.jpg" id="About_pic" alt="about" />
      </div>
    </section>

    <section class="section__container why__container" id="blog">
      <div class="why__image">
        <img src="About img.jpg" alt="why choose us" />
      </div>
      <div class="why__content">
        <h2 class="section__header">Why Choose Us</h2>
        <p>
          With a steadfast commitment to your well-being, our team of highly
          trained healthcare professionals ensures that you receive nothing
          short of exceptional patient experiences.
        </p>
        <div class="why__grid">
          <span><i class="ri-hand-heart-line"></i></span>
          <div>
            <h4>Intensive Care</h4>
            <p>
              Our Intensive Care Unit is equipped with advanced technology and
              staffed by team of professionals
            </p>
          </div>
          <span><i class="ri-truck-line"></i></span>
          <div>
            <h4>Free Ambulance Car</h4>
            <p>
              A compassionate initiative to prioritize your health and
              well-being without any financial burden.
            </p>
          </div>
          <span><i class="ri-hospital-line"></i></span>
          <div>
            <h4>Medical and Surgical</h4>
            <p>
              Our Medical and Surgical services offer advanced healthcare
              solutions to address medical needs.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="section__container doctors__container" id="Doctors">
      <div class="doctors__header">
        <div class="doctors__header__content">
          <h2 class="section__header">Our Special Doctors</h2>
          <p>
            We take pride in our exceptional team of doctors, each a specialist
            in their respective fields.
          </p>
        </div>
      </div>
      <div class="doctors__grid">
        <div class="doctors__card">
          <div class="doctors__card__image">
            <img src="Doctor 51.jpg" alt="doctor" />
            <div class="doctors__socials">
              <span><i class="ri-instagram-line"></i></span>
              <span><i class="ri-facebook-fill"></i></span>
              <span><i class="ri-mail-fill"></i></span>
            </div>
          </div>
          <h4>Dr. Arjun Sen</h4>
          <p>cardiologist</p>
          <p>Expert in heart-related issues with 15+ years of experience in reputed hospitals.</p>
        </div>
        <div class="doctors__card">
          <div class="doctors__card__image">
            <img src="doctor-2.jpg" alt="doctor" />
            <div class="doctors__socials">
              <span><i class="ri-instagram-line"></i></span>
              <span><i class="ri-facebook-fill"></i></span>
              <span><i class="ri-mail-fill"></i></span>
            </div>
          </div>
          <h4>Dr. Priya Das</h4>
          <p>Neurologist</p>
          <p>Specialist in brain and nervous system disorders. Gold medallist from AIIMS.</p>
        </div>
        <div class="doctors__card">
          <div class="doctors__card__image">
            <img src="doctor-3.jpg" alt="doctor" />
            <div class="doctors__socials">
              <span><i class="ri-instagram-line"></i></span>
              <span><i class="ri-facebook-fill"></i></span>
              <span><i class="ri-mail-fill"></i></span>
            </div>
          </div>
          <h4>Dr. Uttam Kumar Haldar</h4>
          <p>Physician</p>
          <p> He is a skilled physician with over 15 years of experience.</p>
        </div>
      </div>
    </section>

    <button class="btn doc"><a href="all_doctors_home.php">See all Doctors</a></button>

    <footer class="footer">
      <div class="section__container footer__container"  id="information">
        <div class="footer__col">
          <img src="logo2.png" id="bottom_pic" alt="about" />
          <p>
            We are honored to be a part of your healthcare journey and committed
            to delivering compassionate, personalized, and top-notch care every
            step of the way.
          </p>
          <p>
            Trust us with your health, and let us work together to achieve the
            best possible outcomes for you and your loved ones.
          </p>
        </div>
        
        <div class="footer__col">
          <h4>About Us</h4>
          <p>Home</p>
          <p>About Us</p>
          <p>Work With Us</p>
          <p>Our Blog</p>
          <p>Terms & Conditions</p>
        </div>
        <div class="footer__col">
          <h4>Services</h4>
          <p>Search Terms</p>
          <p>Advance Search</p>
          <p>Privacy Policy</p>
          <p>Suppliers</p>
          <p>Our Stores</p>
        </div>
        <div class="footer__col" id="footer__col">
          <h4>Contact Us</h4>
          <p>
            <i class="ri-map-pin-2-fill"></i> 733101, Balurghat, Dakshin Dinajpur, West Bengal
          </p>
          <p><i class="ri-mail-fill"></i> <a href="mailto:officialmedlite@gmail.com">officialmedlite</a> </p>
          <p><i class="ri-phone-fill"></i> <a href="tel:+918167384598">(+91) 8167 384 598</a></p>

        </div>
      </div>
      <p class="footer__socials ">
        <i class="ri-instagram-line"></i>
        <i class="ri-facebook-fill"></i>
        <i class="ri-telegram-fill"></i>
      </p>
      <div class="footer__bar">
        <div class="footer__bar__content">
          <p>Copyright © 2025. All rights reserved. Designed and devloped by Team Medlite.+3</p>
          </div>
        </div>
      </div>
    </footer>
    <a href="https://wa.me/8167384598" target="_blank" class="whatsapp-icon">
      <video autoplay loop muted playsinline>
        <source src="whatsapp-animation.webm" type="video/webm">
      </video>
  </body>
</html>
