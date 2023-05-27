import axios from "axios";
export const GET_PRODUCTS = 'products';
export const GET_PRODUCTS_ID = 'products/searchByID'


const state = () => ({
    products: [],
    product_detail: {},
});

const mutations = {
    setProducts(state, products) {
        state.products = products;
    },
    setProductID(state, product_detail) {
        state.product_detail = product_detail;
    }
}

const actions = {
    // async fetchProducts({commit}) {
    //     try {
    //         const response = await axios.get('http://127.0.0.1:8000/api/products')
    //         const products = response.data;
    //         commit('setProducts', products);
    //     } catch (error) {
    //         console.log(error);
    //     }
    // }
    async [GET_PRODUCTS]({ commit }, payload) {
        return new Promise((resolve, reject) => {
          this.$query(GET_PRODUCTS).then(
            (response) => {
                let data = response.data
              commit('setProducts', data)
              resolve(data);
            }).catch(error => {
            reject(error);
          })
        });
      },
      async [GET_PRODUCTS_ID]({ commit }, payload) {
        return new Promise((resolve, reject) => {
          this.$get(GET_PRODUCTS_ID, payload).then(
            (response) => {
                let data = response.data
              commit('setProductID', data)
              resolve(data);
            }).catch(error => {
            reject(error);
          })
        });
      },
}
const getters = {
    getProducts(state) {
        return state.products;
    },
    getProductID(state) {
        return state.product_detail;
    },
    saleItems(state) {
        return state.products.filter(product => product.onSale === true)
    }
}


export default {
    state,
    getters,
    actions,
    mutations,
  };