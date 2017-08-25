<template>
  <div class='date-wrap' @click='alteruserid = false'>
    <div class='header-pic'>
      <input type='file' ref='file' @change="sendfile($event)" accept="image/*" style="display:none" >
      <img :src='pic' @click='test' v-if='togglepic'>
    </div>
    <div class='user-id'>
      {{info['昵称']}}
    </div>
    <ul class='user-info-list'>
      <li v-for='(value,key,index) in info' :key="index" @click='alterid(index,$event)'>
        <div>{{key}}</div>
        <div class='value' :class="{'gray':index<3}">
          {{value}}
          <img src='../.././assets/img/g-arrow.png' v-if='index < 3' />
        </div>
      </li>
    </ul>
    <div class='keep' @click="back">保存</div>
    <transition name='userid'>
      <div class='alterid' v-if='alteruserid'>
        <div class='title'>
          请输入用户名
        </div>
        <div class='content'>
          <input type='text' v-model='userid' maxlength="10" />
        </div>
      </div>
    </transition>
    <mt-actionsheet :actions="sex" v-model="issex">
    </mt-actionsheet>
    <mt-actionsheet :actions="picchoose" v-model="pics">
    </mt-actionsheet>
  
  </div>
</template>

<script>
import BScroll from 'better-scroll'
export default {
  data() {
    return {
      info: [],
      userid: '',
      pic:'',
      togglepic:true,
      alteruserid: false,
      isProvince: true,
      isCity: true,
      issex: false,
      pics: false,
      images: [],
      sex: [{
        name: '男',
        method: () => {
          this.info['性别'] = '男';
        },
      },
      {
        name: '女',
        method: () => {
          this.info['性别'] = '女';
        },
      }
      ],
      picchoose: [{
        name: '上传头像',
        method: () => {
          this.$refs.file.click();
        }
      }]
    }
  },
  created() {
    this.$nextTick(() => {
      this.axios.post('/api/index/Userconter/index').then(res => {
        console.log(res.data);
        let obj = {};
        obj['昵称'] = res.data.username;
        obj['性别'] = res.data.sex;
        obj['年龄'] = res.data.age;
        obj['手机号码'] = res.data.phone;
        this.pic = res.data.pic;
        this.info = obj;
      })
    })
  },
  methods: {
    sendfile(e) {
      var input = event.target,
        file = input.files[0],
        that = this,
        reg = /^image/gi;
      if (!reg.test(file.type)) {
        this.$toast("文件类型错误");
        return;
      };
      var reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function () {
        that.axios.post('/api/index/Userconter/heard',{
            img:this.result,
        }).then(res=>{
          that.pic = res.data.pic;
        })
      }
    },
    test() {
      this.pics = true;
    },
    alterid(index, $event) {
      switch (index) {
        case 0:
          this.$messagebox.prompt('请输入昵称(限10个字符)').then(({ value, action }) => {
            if(value.length>10){
              this.$toast('字数过长');
              return;
            }
            this.info['昵称'] = value;
          }, () => { return; });
          break;
        case 1:
          this.issex = true;
          break;
        case 2:
          this.$messagebox.prompt('请输入年龄').then(({ value, action }) => {
            let reg = /\d/g;
            if(!reg.test(value) || value.length > 3){
                this.$toast('年龄格式错误');
                return;
            }
            this.info['年龄'] = value;
          }, () => { return; });
          break;
      }
    },
    close() {
      this.alteruserid = false;
      this.userid = '';
    },
    back() {
      this.axios.post('/api/index/Userconter/personal',{
        username:this.info['昵称'],
        sex:this.info['性别'],
        age:this.info['年龄']
      })
      this.$toast({
        message: '保存成功',
        duration: 1000
      });
      setTimeout(() => {
        this.$router.push('/Mycenter');
      }, 1500);
    }
  },
}
</script>

<style lang='stylus'>
@css{
  .userid-enter-active,.userid-leave-active{
      transition: all 0.5s;
  }
  .userid-enter,.userid-leave-to{
      transform: translate3d(0,100%,0) 
  }

}
.date-wrap
  width 100vw
  height 100vh
  z-index 2
  background #fff
  position absolute
  top 0
  left 0
  .header-pic
    width 100px
    height 100px
    margin 20px auto
    border-radius 50%
    overflow hidden
    img
      width 100%
  .user-id
    font-size 20px
    font-weight bold
    text-align center
  .keep
    color #fff 
    background #00a1e9
    width 130px
    margin 0 auto
    height 30px
    line-height 30px
    text-align center
    border-radius 6px
  .user-info-list
    margin 30px 0
    border-top 1px solid #e6e6e6
    li
      font-size 18px
      height 40px
      line-height 40px
      border-bottom 1px solid #e6e6e6
      padding 0 4vw
      display flex     
      justify-content space-between
      .value
        color #666
        &.gray
          color #333
  .alterid
    position absolute
    width 100%
    bottom 0
    height 30vh     
    background #f4f5f6
    .title
      height 7vh
      line-height 7vh
      text-align center
    .content
      width 90%
      margin 0 auto
      background #fff
      border 1px solid #e5e5e5
      border-radius 5px
      height 15vh
      box-sizing border-box
      padding 10px
      input
        width 100%
        height 70%
    .confirm
      display flex
      width 90%
      margin 0 auto
      height 7vh
      align-items center
      justify-content space-between
      .tips
        color #777
        flex 1
      .close,.notarize
        flex 0 0 15%
        height 5vh
        line-height 5vh
        text-align center
        border-radius 5px
        color #fff
      .close
        background #cacaca   
      .notarize
        margin-left 10px
        background #00a1e9       
           

</style>
