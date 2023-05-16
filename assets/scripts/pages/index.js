import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

// let sec1 = document.querySelector('#sec-1')
// let sec2 = document.querySelector('#sec-2')
// let sec3 = document.querySelector('#sec-3')

// sec-1
let secTitle1Main = document.querySelector('.sec-1 .sec-title .main')
let secTitle1bar = document.querySelector('.sec-1 .sec-title .bar')
window.addEventListener('load', () => {
  gsap
    .timeline({})
    .to(secTitle1bar, { ease: 'power3', scaleX: 1, duration: 0.6 })
    .to(secTitle1bar, {
      ease: 'power3',
      transformOrigin: 'right',
      scaleX: 0,
      duration: 0.6
    })
    .to(secTitle1Main, { opacity: 1, duration: 0 }, '-=0.6')
})

// sec-2
let secWrapper2 = document.querySelector('.sec-2 .sec-wrapper')
gsap.from(secWrapper2, {
  scale: 2,
  scrollTrigger: {
    trigger: secWrapper2,
    start: 'top bottom',
    end: 'top 20%',
    scrub: true,
    markers: true
  }
})

// sec-3
gsap.to('.name-wrap', {
  xPercent: 100,
  duration: 10,
  repeat: -1,
  ease: 'none'
})
