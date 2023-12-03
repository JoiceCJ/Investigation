$(document).ready(function(){
  var count_particles, stats, update;
 stats = new Stats; // to keep track of how fast things are happening
 stats.setMode(0); // to display those stats
 stats.domElement.style.position = 'absolute'; //css position top left
 stats.domElement.style.top = '0px';
 document.body.appendChild(stats.domElement); //attach stats on webpage
 count_particles = document.querySelector('.js-count-particles'); //to display the count of particles
 update = function() {
   stats.begin();     //recording performance stats
   stats.end();
   if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {  //for checking movement
     count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
   }
   requestAnimationFrame(update);
 };
 requestAnimationFrame(update);   
});