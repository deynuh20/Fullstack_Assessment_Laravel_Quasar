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
      const res = await api.post('/products', product);
      this.products.push(res.data);
    },

    async updateProduct(id: string, product: Partial<Product>) {
      const res = await api.put(`/products/${id}`, product);
      const idx = this.products.findIndex(p => p.product_id === id);
      if (idx !== -1) this.products[idx] = res.data;
    },

    async deleteProduct(id: string) {
      await api.delete(`/products/${id}`);
      this.products = this.products.filter(p => p.product_id !== id);
    }
  }
});
