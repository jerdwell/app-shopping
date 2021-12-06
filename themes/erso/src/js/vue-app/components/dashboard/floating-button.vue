<template lang="pug">
   div
    div.floating-button(@click.prevent="isActive = !isActive" :class="{'square reverse': isActive }") 
        img(src="/themes/erso/assets/img/logo2.png", alt="alt" :class="{'hide': isActive }")
        span.title.hide(:class="{'show': isActive }") WhatsApp 
            img(src="/themes/erso/assets/img/logo2.png", alt="alt" :class="{'hide': !isActive }")
        a.fab-child(@click="openWhats('https://wa.me/525527358877')" :class="{'show': isActive }") Coacalco
        a.fab-child(@click="openWhats('https://wa.me/525549828827')" :class="{'show': isActive }") Tlalnepantla
        a.fab-child(@click="openWhats('https://wa.me/525546105175')" :class="{'show': isActive }") Cuautitlán Izcalli
</template>

<script>
export default {
    name: "floating-button",
    data() {
        return {
            isActive: false,
        };
    },
    methods: {
        openWhats(phone) {
            window.open(phone, "_blank");
        },
    },
};
</script>

<style lang="sass">
.hide
    display: none

.title
    display: none
    padding: 10px
    font-weight: bold
    height: 40px
    background-color: #40c351
    color: #FFF
    width: 100%
    display: flex
    justify-content: center
    border-radius: 10px 10px 0 0
    img
        margin-left: 5px


.floating-button
    background-color: #40c351
    font-weight: bold
    width: 50px
    height: 50px
    border-radius: 50%
    position: fixed
    right: 7%
    bottom: 5%
    display: flex
    justify-content: center
    color: white
    align-items: center
    cursor: pointer
    z-index: 10
    animation-name: zoomout
    animation-duration: .02s
    animation-delay: 0
    animation-direction: alternate
    animation-timing-function: ease-in
    animation-iteration-count: 1
    animation-fill-mode: none
    animation-play-state: running
    img
        width: 20px
    @media screen and ( min-width: 768px )
        right: 30px
        bottom: 10%
.fab-container
    flex-direction: column
    height: 25%
    align-items: space-between
    border-radius: 50%
    position: fixed
    right: 60px
    bottom: 13%
    display: none
.fab-child
    border-top: 2px solid #f4f4f4
    color: #000 !important
    padding: 10px
    width: 100%
    display: none
    color: white
    justify-content: center
    align-items: center
    animation-name: easyin
    animation-duration: .02s
    animation-delay: 0
    animation-direction: alternate
    animation-timing-function: ease-in
    animation-iteration-count: 1
    animation-fill-mode: none
    animation-play-state: running
.show
    display: flex !important
    animation-name: show
    animation-duration: .02s
    animation-delay: 0
    animation-direction: alternate
    animation-timing-function: ease-in
    animation-iteration-count: 1
    animation-fill-mode: none
    animation-play-state: running
.hide
    display: none
.square
    display: flex
    color: #000
    flex-direction: column
    width: 250px
    height: auto
    background-color: white
    border-radius: 10px
    animation-name: zoomin
    animation-duration: .02s
    animation-delay: 0
    animation-direction: alternate
    animation-timing-function: ease-in
    animation-iteration-count: 1
    animation-fill-mode: none
    animation-play-state: running
.padd
    margin-top: 5px
.reverse
    flex-direcion: row-reverse !important
@keyframes show
    0%
        opacity: 0
    100%
        opacity: 1
@keyframes zoomin
  0%
    background-color: #40c351
    width: 50px
  50%
    background-color: white
    width: 150px

  100%
    background-color: white
    width: 200px
@keyframes zoomout
  0%
    width: 200px
    border-radius: 10px

  50%
    width: 150px
    background-color: #40c351
    border-radius: 10px

  100%
    width: 50px
    background-color: #40c351
    border-radius: 50%

@keyframes easyin
    0%
        display: none
        opacity: 0
    100%
        opacity: 1
        display: block
</style>
