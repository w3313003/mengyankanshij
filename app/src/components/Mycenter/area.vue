<template>
    <div>
        <div class='area' ref="area">
            <transition name='area'>
                <ul class='province' v-if='!iscity'>
                    <li v-for='(item,index) in area' :key="item" @click='showcity(index)'>
                        {{item.province}}
                        <img src='../.././assets/img/g-arrow.png' />
                    </li>
                </ul>
            </transition>
            <transition name='city'>
                <ul class='city'  v-if='iscity'>
                    <li v-for='(item,index) in city' :key="item" @click='backTodata(item,index)'>
                        {{item}}
                        <img src='../.././assets/img/g-arrow.png' />
                    </li>
                </ul>
            </transition>
        </div>
    </div>
</template>
<style lang="stylus">
@css{
    .area{
      width:100vw;
      height:100vh;
      background : #fff;
      position:absolute;
      box-sizing:border-box;
      left :0;
      top:0;
      z-index:3;
      margin-bottom:20px;
      overflow:scroll;
      -webkit-overflow-scrolling: touch;
  }
  .province li {
    width:100%;
    font-size: 20px;
    height : 40px;
    line-height :40px;
    box-sizing :border-box;
    font-weight:400;
    display : flex;
    justify-content :space-between;
    padding : 0 15px;
    border-bottom : 1px solid #f0f0f0;
    }
    .province li img{
        transform:scale(0.5,0.5)
    }
    .city{
        position:absolute;
        width:100%;
        height:100%;
        top:0;
        left:0;
        z-index:999;
    }
    .city li{
        width:100%;
        font-size: 20px;
        height : 40px;
        line-height :40px;
        box-sizing :border-box;
        font-weight:400;
        display : flex;
        justify-content :space-between;
        padding : 0 15px;
        border-bottom : 1px solid #f0f0f0;
    }
    .city li img{
        transform:scale(0.5,0.5)
    }
    .area-enter-active,.area-leave-active{
        transition:all 1s;
    }
    .area-enter,.area-leave-to{
        transform : translate3d(100%,0,0)
    }
    .city-enter-active,.city-leave-active{
        transition:all 1s;
    }
    .city-enter,.city-leave-to{
        transform : translate3d(-100%,0,0)
    }
}
</style>

<script>
import Bscroll from "better-scroll"
export default {
    data() {
        return {
            area: [],
            city: [],
            iscity: false,
        }
    },
    created() {
        this.$nextTick(() => {
            this.area = this.$store.getters.getArea;
        })
    },
    methods: {
        showcity(index) {
            this.city = this.area[index].city;
            this.iscity=true;
        },
        backTodata(item,index){
            this.$store.commit('setArea',item);
            let tip = this.$toast("操作成功",1000);
            setTimeout(() => {
                tip.close();
                this.$router.push({name:'pData'});
            },1000)
            
        }
    }
}
</script>
