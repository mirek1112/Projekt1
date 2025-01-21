<template>
    <div v-if="isVisible" class="modal-overlay">
      <div class="modal-content">
        <h2>Add New Person</h2>
        <form @submit.prevent="submitForm">
          <div>
            <label for="first-name">First Name:</label>
            <input
              type="text"
              id="first-name"
              v-model="form.firstName"
              required
              placeholder="Enter first name"
            />
          </div>
          <div>
            <label for="last-name">Last Name:</label>
            <input
              type="text"
              id="last-name"
              v-model="form.lastName"
              required
              placeholder="Enter last name"
            />
          </div>
          <div>
            <label for="birthdate">Birth Date:</label>
            <input
              type="date"
              id="birthdate"
              v-model="form.birthDate"
              required
            />
          </div>
          <div>
            <label for="country">Country:</label>
            <select
              id="country"
              v-model="form.country"
              required
            >
              <option v-for="country in countries" :key="country.id" :value="country.id">
                {{ country.name }}
              </option>
            </select>
          </div>
          <div>
            <label for="hobbies">Hobbies:</label>
            <select
              id="hobbies"
              v-model="form.hobbies"
              multiple
              required
            >
              <option v-for="hobby in hobbies" :key="hobby.id" :value="hobby.id">
                {{ hobby.name }}
              </option>
            </select>
          </div>
          <button type="submit">Add Person</button>
          <button type="button" @click="closeModal">Cancel</button>
        </form>
      </div>
    </div>
  </template>

  <script setup>
  import { reactive, ref, onMounted } from 'vue';
  import { router } from '@inertiajs/vue3';
  import axios from 'axios';


  const props = defineProps({
    isVisible: {
      type: Boolean,
      required: true,
    },
    onClose: {
      type: Function,
      required: true,
    },
    onSubmit: {
      type: Function,
      required: true,
    },
  });

  const form = reactive({
    firstName: '',
    lastName: '',
    birthDate: '',
    country: null,
    hobbies: [],
  });

  const countries = ref([]);
  const hobbies = ref([]);

  const closeModal = () => {
    props.onClose();
  };

  const submitForm = () => {
    const formData = {
      first_name: form.firstName,
      last_name: form.lastName,
      birth_date: form.birthDate,
      country_id: form.country,
      hobbies: form.hobbies,
    };

    router.post('/users', formData);

  };

  const fetchData = async () => {
  try {

    const countriesResponse = await axios.get('countries');
    countries.value = countriesResponse.data;
    const hobbiesResponse = await axios.get('hobbies');
    hobbies.value = hobbiesResponse.data;
  } catch (error) {
    console.error('Error:', error);
  }
};

  onMounted(() => {
    fetchData();
  });
  </script>

  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 400px;
  }

  .modal-content h2 {
    margin-bottom: 16px;
  }

  .modal-content form div {
    margin-bottom: 12px;
  }

  .modal-content input,
  .modal-content select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }

  button {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  button[type='submit'] {
    background-color: #4CAF50;
    color: white;
  }

  button[type='button'] {
    background-color: #f44336;
    color: white;
  }

  button:hover {
    opacity: 0.8;
  }
  </style>
