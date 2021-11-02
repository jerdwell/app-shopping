import Slide from './modules/Slide'
import Navbar from './modules/Navbar'
import AOS from './modules/AOS'
import BlogBrowserFixer from './modules/BlogBrowserFixer'

Slide.init('main-slide', 8000)
Navbar.init()


window.onload = () => { BlogBrowserFixer.fixBrowser() }

