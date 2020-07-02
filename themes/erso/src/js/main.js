import Slide from './modules/Slide'
import Navbar from './modules/Navbar'

Slide.init('main-slide', 8000)

window.onload = function(){
  Navbar.init()
}