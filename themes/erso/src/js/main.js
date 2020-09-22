import Slide from './modules/Slide'
import Navbar from './modules/Navbar'
import AOS from './modules/AOS'

Slide.init('main-slide', 8000)

window.onload = function(){
  Navbar.init()
}

