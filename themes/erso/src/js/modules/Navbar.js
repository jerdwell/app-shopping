const Navbar = {

  data: {
    class_navbar_fixed: 'navbar-main-erso-fixed',
    class_navbar: 'navbar-main-erso',
    navbar: document.querySelector('.navbar-main-erso'),
    icon_main_menu: document.querySelector('.icon-menu-navbar-erso'),
    main_menu: document.querySelector('.main-menu-erso'),
    main_menu_inactive: 'navbar-main-inactive-erso',
    max_scroll: 300
  },

  init(){
    let navbar = this.data.navbar
    if(!document.querySelector('.navbar-main-erso')) return
    document.onscroll = () => this.toggleNavbar()
    this.data.icon_main_menu.addEventListener('click', () => this.toggleMainMenu())
  },

  toggleNavbar(){
    let scroll = window.scrollY
    if(scroll >= this.data.max_scroll){
      if(!this.data.navbar.classList.contains(this.data.class_navbar_fixed)) this.data.navbar.classList.add(this.data.class_navbar_fixed)
    }else{
      if(this.data.navbar.classList.contains(this.data.class_navbar_fixed)) this.data.navbar.classList.remove(this.data.class_navbar_fixed)
    }
  },

  toggleMainMenu() {
    let contains = this.data.main_menu.classList.contains(this.data.main_menu_inactive)
    if(!contains){
      this.data.main_menu.classList.add(this.data.main_menu_inactive)
      document.body.style.overflow = 'auto'
    }else{
      this.data.main_menu.classList.remove(this.data.main_menu_inactive)
      document.body.style.overflow = 'hidden'
    }
  }

}

module.exports = Navbar