const BlogBrowserFixer = {

  data: {
    target: 'blog-filters'
  },
  
  fixBrowser(){
    const element = document.getElementById(this.data.target)
    if(!element) return false
    window.scrollTo(0,0)
    const parent = document.querySelector('.blog-filters-container')
    const height = element.offsetHeight
    let parent_width = parent.offsetWidth
    let position = element.getBoundingClientRect()
    window.onscroll = () => {
      if(window.scrollY > (position.top + height)){
        if(!element.classList.contains('blog-filters-fixed')){
          element.style.width = parent_width + 'px'
          element.classList.add('blog-filters-fixed')
        }
      }else{
        if(element.classList.contains('blog-filters-fixed')){
          element.classList.remove('blog-filters-fixed')
          element.style.width = 'auto'
        }
      }
    }
  },


}

export default BlogBrowserFixer