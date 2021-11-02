<template lang="pug">
div
    ul.list-group.list-group-flush
        li.list-group-item.bg-transparent.border-yellow(v-for="(category, index ) in categories.data" :key="category.id")
            input.mr-2(type="checkbox" :value="category.slug" name="category" :id="category.slug" v-model="filter")
            span.text-light {{ category.name }}
    div.text-center.mt-5
        button.btn.btn-block.btn-info(@click.prevent="filterPosts") Filtrar
</template>
<script>
export default {
    name: 'category-filter-blog',
    data() {
        return {
            filter: []
        }
    },
    props: [
        'categories'
    ],
    methods: {
        filterPosts(){
            if(this.filter.length <= 0){
                this.$swal('Fitrado de categorías', 'Por favor selecciona las categorías para filtrar', 'warning')
                return
            }
            let url = '/blog/categories/' + this.filter.join(',')
            window.location.assign(url)
        }
    },
}
</script>