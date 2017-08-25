export default {
    toggleList(state, payload) {
        state.newList = payload;
    },
    setArea(state,payload){
        state.info[2].value = payload;
    },
    setAge(state,payload){
        state.info[3].value = payload;
    },
    saveHistory(state,payload){
        state.history.concat(payload);
    },
    setSex(state,payload){
        state.info[1].value = payload;
    },
    setVideo(state,payload){
        state.currentVideo = {};
        state.currentVideo = payload;
    },
    setVideo2(state,payload){

        state.currentVideo2 = payload;
    },
    rCurrentid(state,payload){
        state.currentId = '';
        state.currentId = payload;
    },
}