<template>
  <div>
    <DesktopNavAdmin />
    <v-container>
      <h2>Danh sách thông tin sản phẩm</h2>
      <v-row>
        <v-col v-for="(item, index) in products" :key="index" cols="12" md="4">
          <v-card class="product-card" outlined>
            <v-img :src="item.image" height="200"></v-img>
            <v-card-title>{{ item.name }}</v-card-title>
            <v-card-text>
              <p>Mã sản phẩm: {{ item.id }}</p>
              <p>Giá: {{ item.price }}</p>
              <p>Số lượng: {{ item.quantity }}</p>
              <p>Mô tả: {{ item.description }}</p>
              <p>Loại hàng: {{ item.tag_name }}</p>
              <p>Giảm giá: {{ item.discount }}%</p>
            </v-card-text>
            <v-card-actions>
              <v-btn @click="update(item.id)" text color="primary">
                Cập nhật
              </v-btn>
              <v-btn @click="changePassword(item.id)" text color="error">
                Bảo mật
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <Footer />
    <ScrollTop />
  </div>
</template>

<script>
export default {
  data() {
    return {
      products: [],
    };
  },
  methods: {
    update(productId) {
      // Xử lý cập nhật sản phẩm với ID là productId
      console.log('Cập nhật sản phẩm với ID:', productId);
    },
    changePassword(productId) {
      // Xử lý thay đổi mật khẩu sản phẩm với ID là productId
      console.log('Thay đổi mật khẩu sản phẩm với ID:', productId);
    },
  },
  mounted() {
    this.$axios
      .get('http://127.0.0.1:8000/api/products')
      .then((response) => {
        this.products = response.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

<style scoped>
h2 {
  text-align: center;
}

.product-card {
  margin-bottom: 20px;
}

.product-card img {
  object-fit: cover;
  width: 100%;
}

.product-card p {
  margin: 0;
}
</style>
