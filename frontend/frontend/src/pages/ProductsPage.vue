<template>
  <q-page class="q-pa-md">
    <div class="row justify-between items-center q-mb-md">
      <q-btn color="primary" label="Add Product" @click="openAddDialog" />
    </div>

    <q-table
      :rows="products"
      :columns="columns"
      row-key="product_id"
      flat
      bordered
    >
      <template v-slot:body="props">
        <template v-if="!props.row.product_parent_id">
          <q-tr>
            <q-td>{{ props.row.product_name }}</q-td>
            <q-td>{{ props.row.product_type }}</q-td>
            <q-td class="text-right">
              <q-btn
                flat round icon="edit" size="sm" color="primary"
                @click="editProduct(props.row)"
              />
              <q-btn
                flat round icon="delete" size="sm" color="negative"
                @click="deleteProduct(props.row.product_id)"
              />
            </q-td>
          </q-tr>

          <q-tr
            v-for="child in products.filter(c => c.product_parent_id === props.row.product_id)"
            :key="child.product_id"
            class="bg-grey-3 text-grey-9"
          >
            <q-td class="q-pl-xl">
              <small><strong>{{ child.product_name }}</strong></small>
            </q-td>
            <q-td><small>{{ child.product_type }}</small></q-td>
            <q-td class="text-right">
              <q-btn
                flat round icon="edit" size="sm" color="primary"
                @click="editProduct(child)"
              />
              <q-btn
                flat round icon="delete" size="sm" color="negative"
                @click="deleteProduct(child.product_id)"
              />
            </q-td>
          </q-tr>
        </template>
      </template>
    </q-table>

    <q-dialog v-model="showDialog">
      <q-card>
        <q-card-section>
          <q-select
            v-model="form.product_parent_id"
            :options="products.map(p => ({ label: p.product_name, value: p.product_id }))"
            emit-value
            map-options
            label="Parent Product"
            clearable
          />
          <q-input v-model="form.product_name" label="Product Name" />
          <q-input v-model="form.product_type" label="Product Type" />
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Cancel" v-close-popup />
          <q-btn flat label="Save" color="primary" @click="saveProduct" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useProductStore } from 'src/stores/productStore'
import type { QTableProps } from 'quasar'
import type { Product } from 'src/types/product'

const productStore = useProductStore()
const products = ref<Product[]>([])

const showDialog = ref(false)
const form = ref<Partial<Product>>({})

const columns: QTableProps['columns'] = [
  { name: 'product_name', label: 'Name', field: 'product_name', align: 'left' },
  { name: 'product_type', label: 'Type', field: 'product_type', align: 'left' },
  { name: 'actions', label: 'Actions', field: 'actions', align: 'right' }
]

onMounted(async () => {
  await productStore.fetchProducts()
  products.value = productStore.products
})

function openAddDialog() {
  form.value = {}
  showDialog.value = true
}

async function saveProduct() {
  const product = {
    product_name: form.value.product_name ?? '',
    product_type: form.value.product_type ?? '',
    product_parent_id: form.value.product_parent_id ?? null
  }
  if (form.value.product_id) {
    await productStore.updateProduct(form.value.product_id, product)
  } else {
    await productStore.addProduct(product as Omit<Product, 'product_id'>)
  }
  await productStore.fetchProducts()
  products.value = productStore.products
  showDialog.value = false
}

function editProduct(product: Product) {
  form.value = { ...product }
  showDialog.value = true
}

async function deleteProduct(id: string) {
  await productStore.deleteProduct(id)
  await productStore.fetchProducts()
  products.value = productStore.products
}
</script>
