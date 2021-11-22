<template lang="pug">
   div
    div.floating-button(@click.prevent="isActive = !isActive" :class="{'square': isActive }") 
        i.fas.fa-phone-alt(:class="{'padd show':isActive}")
        a.fab-child(@click="openWhats('https://wa.me/525527358877')" :class="{'show': isActive }") Coacacalco
        a.fab-child(@click="openWhats('https://wa.me/525549828827')" :class="{'show': isActive }") Tlalnepantla
        a.fab-child(@click="openWhats('https://wa.me/525546105157')" :class="{'show': isActive }") Cuatitlan Izcalli
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
            window.open(phone, "_blank")
        },
    },
};
</script>

<style lang="sass">
.floating-button
    background-color: #40c351
    width: 50px
    height: 50px
    border: 4px solid white
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
    border: 2px solid white
    color: #40c351
    display: none
    color: white
    border: none
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
    display: flex
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
    padding: 10px
    flex-direction: column
    width: 200px
    height: 100px
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
@keyframes show
    0%
        opacity: 0 
    100%
        opacity: 1
@keyframes zoomin 
  0% 
    width: 50px
    height: 50px
  50% 
    width: 150px
    height: 80px
  
  100% 
    width: 200px
    height: 100px
@keyframes zoomout 
  0% 
    width: 200px
    height: 100px
    border-radius: 10px 

  50% 
    width: 150px
    height: 80px
    border-radius: 10px 
  
  100% 
    width: 50px
    height: 50px
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
