/**
 * Ryhze Pre-Launch Landing Page JavaScript
 * Handles animations, scrolling effects, and form validation
 */

document.addEventListener('DOMContentLoaded', function() {
  // Initialize variables
  const header = document.querySelector('.site-header');
  const mobileToggle = document.querySelector('.mobile-toggle');
  const navMenu = document.querySelector('.nav-menu');
  const scrollElements = document.querySelectorAll('.animate-on-scroll');
  
  // Mobile menu toggle
  if (mobileToggle) {
    mobileToggle.addEventListener('click', function() {
      navMenu.classList.toggle('active');
      
      // Toggle between menu and close icons
      const icon = this.querySelector('i');
      if (icon.classList.contains('fa-bars')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
      } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
      }
    });
  }
  
  // Close mobile menu when clicking outside
  document.addEventListener('click', function(event) {
    if (navMenu && navMenu.classList.contains('active') && !event.target.closest('.site-header')) {
      navMenu.classList.remove('active');
      const icon = mobileToggle.querySelector('i');
      icon.classList.remove('fa-times');
      icon.classList.add('fa-bars');
    }
  });
  
  // Header scroll effect
  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
      header.classList.add('header-scrolled');
    } else {
      header.classList.remove('header-scrolled');
    }
    
    // Check for scroll animations
    scrollElements.forEach(el => {
      if (isElementInViewport(el)) {
        el.classList.add('visible');
      }
    });
  });
  
  // Trigger scroll once to check for elements in viewport on load
  setTimeout(function() {
    window.dispatchEvent(new Event('scroll'));
  }, 100);
  
  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      
      const targetId = this.getAttribute('href');
      
      if (targetId === '#') return;
      
      const targetElement = document.querySelector(targetId);
      
      if (targetElement) {
        // Close mobile menu if open
        if (navMenu && navMenu.classList.contains('active')) {
          navMenu.classList.remove('active');
          const icon = mobileToggle.querySelector('i');
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        }
        
        window.scrollTo({
          top: targetElement.offsetTop - 80,
          behavior: 'smooth'
        });
      }
    });
  });
  
  // Form validation
  const signupForm = document.querySelector('form');
  if (signupForm) {
    signupForm.addEventListener('submit', function(e) {
      const emailInput = document.getElementById('email');
      const nameInput = document.getElementById('name');
      const interestCheckboxes = document.querySelectorAll('input[name="interests[]"]:checked');
      
      let isValid = true;
      
      // Validate name
      if (nameInput.value.trim() === '') {
        isValid = false;
        nameInput.classList.add('error');
      } else {
        nameInput.classList.remove('error');
      }
      
      // Validate email
      if (emailInput.value.trim() === '' || !isValidEmail(emailInput.value)) {
        isValid = false;
        emailInput.classList.add('error');
      } else {
        emailInput.classList.remove('error');
      }
      
      // Optional: validate at least one interest is selected
      // if (interestCheckboxes.length === 0) {
      //   isValid = false;
      //   document.querySelector('.checkbox-group').classList.add('error');
      // } else {
      //   document.querySelector('.checkbox-group').classList.remove('error');
      // }
      
      if (!isValid) {
        e.preventDefault();
      }
    });
  }
  
  // Helper functions
  function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
      rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.8
    );
  }
  
  function isValidEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }
});

// Custom animations on page load
window.addEventListener('load', function() {
  // Initialize any elements that should be visible on load
  const scrollElements = document.querySelectorAll('.animate-on-scroll');
  scrollElements.forEach(el => {
    if (isElementInViewport(el)) {
      el.classList.add('visible');
    }
  });
  
  function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
      rect.top <= (window.innerHeight || document.documentElement.clientHeight)
    );
  }
});
