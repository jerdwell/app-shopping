const Slide = {

  data: {
    target: '',
    slide_container: 'slide-container',
    slide_items: 'slide-item',
    time: null,
    next: 'slide-controls-next',
    prev: 'slide-controls-prev',
    dots: 'dot-indicator',
    index: 0
  },

  init(target, time){
    this.data.target = target
    if(!document.getElementById(this.data.target)) return
    this.data.time = time
    this.sizeSlide()
    window.addEventListener('resize', this.sizeSlide())
    this.slideInterval()
    document.getElementById(this.data.next).addEventListener('click', () => { this.actionControls('next') })
    document.getElementById(this.data.prev).addEventListener('click', () => { this.actionControls('prev') })
  },

  /**
   * actions in prev and next buttons
   */
  actionControls(action){
    this.data.index = action == 'next' ? this.data.index + 1 : this.data.index - 1
    this.moveSlide()
  },
  
  /**
   * move slide from side
   */
  moveSlide(){
    let childs = document.querySelectorAll(`.${this.data.slide_items}`)
    if(this.data.index >= childs.length) this.data.index = 0
    if(this.data.index < 0) this.data.index = childs.length -1
    let container = document.querySelector(`.${this.data.slide_container}`)
    let target = document.getElementById(`${this.data.target}`)
    container.style.marginLeft = '-' + this.data.index * target.offsetWidth + 'px'
    this.setStateDots()
  },

  /**
   * change active - inactive in dots
   */
  setStateDots(){
    let dots = document.querySelectorAll(`.${this.data.dots}`)
    dots[0].classList.add(`${this.data.dots}-active`)
    for (let dot in Array.from(dots)) {
      if(dots[dot].classList.contains(`${this.data.dots}-active`)) dots[dot].classList.remove(`${this.data.dots}-active`)
    }
    dots[this.data.index].classList.add(`${this.data.dots}-active`)
  },
  
  /**
   * set the timer to repeat action
   */
  slideInterval(){
    let intrvl = setInterval(() => {
      this.data.index ++
      this.moveSlide()
    }, this.data.time);
    let dots = document.querySelectorAll(`.${this.data.dots}`)
    dots.forEach(e => {
      e.addEventListener('click', (event) => {
        let el = event.target
        this.data.index = el.getAttribute('data-index')
        this
        this.moveSlide() //move the slide
        clearInterval(intrvl) //cleart timer to interval
        this.slideInterval() //recursive to restart interval
      })
    })
  },

  /**
   * set the size in slide
   */
  sizeSlide(){
    let items = document.querySelectorAll(`.${this.data.slide_items}`)
    let nItems = items.length
    let container = document.querySelector(`.${this.data.slide_container}`)
    container.style.width = `${nItems * 100}%`
  }

}

module.exports = Slide
// TODO(erdwell): Add features to touch events