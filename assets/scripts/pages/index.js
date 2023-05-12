import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

let secWrapperArray = document.querySelectorAll('.sec-wrapper')

secWrapperArray.forEach(secWrapper => {
  gsap.from(secWrapper, {
    scale: 0.8,
    scrollTrigger: {
      trigger: secWrapper,
      start: 'top bottom',
      end: 'top 60%',
      scrub: true,
      markers: true
    }
  })
})
