export default {
    getRating :state => state.ratingList,
    getNewList :state => state.newList,
    getArea :state =>  state.area,
    getUserInfo :state => state.info,
    getHistory: state => state.history,
    test: state => {
        state.count += 10;
        return state.count;
    }
}
