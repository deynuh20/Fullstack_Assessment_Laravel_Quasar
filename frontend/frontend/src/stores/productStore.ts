import { defineStore } from 'pinia';
import api from 'src/services/api';
import type { Product } from 'src/types/product';

export const useProductStore = defineStore('products', {
  state: () => ({
    products: [] as Product[],
    loading: false,
  }),

  actions: {
    async fetchProducts() {
      this.loading = true;
      try {
        const res = await api.get('/products');
        this.products = res.data;
      } finally {
        this.loading = false;
      }
    },

    async addProduct(product: Omit<Product, 'product_id'>) {
      await api.post('/products', product);
    },

    async updateProduct(id: string, product: Partial<Product>) {
      await api.put(`/products/${id}`, product);
    },

    async deleteProduct(id: string) {
      await api.delete(`/products/${id}`);
    }
  }
});
