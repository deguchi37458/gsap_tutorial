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
    .to(secTitle1bar, { ease: 'power3', scaleX: 1, duration: 0.8 })
    .to(secTitle1bar, {
      ease: 'power3',
      transformOrigin: 'right',
      scaleX: 0,
      duration: 0.8
    })
    .to(secTitle1Main, { opacity: 1, duration: 0 }, '-=0.8')
})

// sec-2
let secWrapper2 = document.querySelector('.sec-2 .sec-wrapper')
gsap.from(secWrapper2, {
  scale: 2,
  scrollTrigger: {
    trigger: secWrapper2,
    start: 'top bottom',
    end: 'top top',
    scrub: true,
    markers: true
  }
})

// sec-3
let secTitle3 = document.querySelector('.sec-3 .sec-title')
gsap.to(secTitle3, {
  x: 1200,
  scrollTrigger: {
    trigger: secTitle3,
    start: 'top bottom',
    end: 'bottom top',
    scrub: true,
    markers: true
  }
})
