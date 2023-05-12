import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

gsap.utils.toArray('.js-parallax').forEach(wrap => {
  const y = wrap.getAttribute('data-y') || -150

  gsap.to(wrap, {
    y: y,
    scrollTrigger: {
      trigger: wrap,
      start: 'top bottom',
      end: 'bottom top',
      scrub: 0.5,
      markers: true
    }
  })
})

// ScrollTrigger.create({
//   trigger: '.b2',
//   pin: true,
//   markers: true,
//   ease: 'power2.inOut'
//   // end: 'bottom 30%' //などと設定するとfixedの期間がより短くなる
// })

const listWrapperEl = document.querySelector('.sec-novel')
const listEl = document.querySelector('.sec-novel__content')
const scrollGap = listEl.clientWidth - listWrapperEl.clientWidth
gsap.to(listEl, {
  x: scrollGap,
  ease: 'none',
  scrollTrigger: {
    trigger: listWrapperEl,
    start: 'top top',
    end: `top+=${scrollGap}`,
    scrub: true,
    pin: true,
    anticipatePin: 1,
    invalidateOnRefresh: true
  }
})
