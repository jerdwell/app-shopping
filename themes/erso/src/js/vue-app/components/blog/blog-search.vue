<template lang="pug">
.blog-search
  label.label Buscar
  input.form-control(
    type="search"
    name="blog-search"
    id="blog-search"
    v-model="data_search"
    @input="blogSearch")
  .text-center(v-if="loading")
    .spinner-border.spinner-border-sm
  popUpSearcheable.search-results(v-if="show_pop")
    template(slot="pop-header")
      .d-flex.flex-wrap.justify-content-between.align-items-center
        span #[b Resultados]
        .fas.fa-times.text-danger(@click.prevent="show_pop = !show_pop" style="cursor:pointer;")
    template(slot="pop-content")
      ul.list-group.list-group-flush(v-if="results.length > 0")
        li.list-group-item.m-0.py-1(v-for="result in results" :key="result.id")
          a.link.link-muted.text-muted(:href="'/blog/post/' + result.slug")
            img.result-thumbnail.mr-2(:src="result.cover.path")
            small {{ result.title }}
      ul.list-group.list-group-flush(v-else)
        span.link.link-muted.text-danger(@click.prevent="show_pop = !show_pop" style="cursor:pointer;") #[.fas.fa-times] No existen resultados
</template>

<script>
import popUpSearcheable from '../dashboard/pop-up-searcheable'
export default {
  name: 'blog-search',
  components: {
    popUpSearcheable
  },
  data() {
    return {
      loading: false,
      data_search: '',
      results: [],
      show_pop: false
    }
  },
  methods: {
    async blogSearch(){
      try {
        if(this.data_search.replace(/\s/g, '').length <= 3) return false
        this.loading = true
        let list_blog = []
        let search = await this.$http.post('blog/search', { data: this.data_search })
        this.loading = false
        this.results = search.data
        this.show_pop = true
      } catch (error) {
        this.loading = false
        console.log(error)
      }
    }
  },
}
</script>

<style lang="sass">
  .blog-search
    position: relative
    .search-results
      position: absolute
      right: 0!important
      top: 100%
      width: 100%
  .result-thumbnail
    height: 30px
    object-fit: cover
    object-position: center
    width: 30px
</style>