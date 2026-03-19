<template>
  <div>
    <ApartmentList
      ref="apartmentList"
      @create="showForm = true; editingApartment = null"
      @edit="handleEdit"
      @deleted="handleDeleted"
    />

    <ApartmentFormModern
      v-if="showForm"
      :apartment="editingApartment"
      @close="showForm = false; editingApartment = null"
      @saved="handleSaved"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import ApartmentList from '../components/ApartmentList.vue'
import ApartmentFormModern from '../components/ApartmentFormModern.vue'

const showForm = ref(false)
const editingApartment = ref(null)
const apartmentList = ref(null)

const handleEdit = (apartment) => {
  editingApartment.value = apartment
  showForm.value = true
}

const handleSaved = () => {
  apartmentList.value?.refresh()
}

const handleDeleted = () => {
  // Optional: Show success message
}
</script>
