function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
  
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
  }
  
  
  // Animation au scroll
  const faders = document.querySelectorAll('[data-animate]');
  
  const appearOnScroll = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if(entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.2,
  });
  
  faders.forEach(fader => {
    appearOnScroll.observe(fader);
  });
  