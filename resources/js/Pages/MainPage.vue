<template>
    <div>
      <div class="centered-button">
        <button @click="reloadData" class="reload-button">NAČÍST NOVÉ DATA</button>
        <button @click="openModal" class="reload-button">ADD PERSON</button>
        <button @click="deleteSelected" class="reload-button">DELETE SELECTED</button>
      </div>

      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search by name"
        class="search-input"
      />

      <Modal :isVisible="isModalVisible" :onClose="closeModal" :onSubmit="addPerson" />

      <div class="card-container">
        <Card
          v-for="item in filteredData"
          :key="item.id"
          :item="item"
          :selectedHobbies="selectedHobbies"
          :isSelected="selectedCards[item.id]"
          @toggleSelection="toggleCardSelection(item.id)"
        />
      </div>

      <div class="mt-4 p-4 bg-gray-100 rounded shadow">
        <div>
          <ul>
            <li
              v-for="(count, hobby) in filteredHobbies"
              :key="hobby"
              :class="{
                'selected-hobby': selectedHobbies[hobby],
                'unselected-hobby': !selectedHobbies[hobby],
                'hobby-item': true
              }"
              @click="toggleHobbySelection(hobby)"
            >
              {{ hobby }}: {{ count }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </template>


<script setup>
import Modal from '@/Components/Modal.vue';
import Card from '@/Components/Card.vue';
import axios from 'axios';
import { reactive, defineProps, computed, ref } from 'vue';

const props = defineProps({
  data: {
    type: Array,
    required: true,
  },
  hobbyUsageCount: {
    type: Object,
    required: true,
  },
});

const isModalVisible = ref(false);
const searchQuery = ref('');

const openModal = () => {
  isModalVisible.value = true;
};

const closeModal = () => {
  isModalVisible.value = false;
};

const addPerson = (personData) => {
  console.log('New person added:', personData);
};

const selectedHobbies = reactive({});
const toggleHobbySelection = (hobby) => {
  selectedHobbies[hobby] = !selectedHobbies[hobby];
};

const filteredHobbies = computed(() => {
  return Object.fromEntries(
    Object.entries(props.hobbyUsageCount).filter(([_, count]) => count > 0)
  );
});

const data = reactive([...props.data]);

const filteredData = computed(() => {
  const query = searchQuery.value.toLowerCase();
  return data.filter((item) =>
    item.hobbies.some((hobby) => hobby.name.toLowerCase().includes(query))
  );
});

const selectedCards = reactive({});

const toggleCardSelection = (id) => {
  if (!selectedCards.hasOwnProperty(id)) {
    selectedCards[id] = true;
  } else {
    selectedCards[id] = !selectedCards[id];
  }

  console.log(selectedCards);
};

const reloadData = async () => {
  try {
    await axios.get('/newData');
    window.location.reload();
  } catch (error) {
    console.error('Failed to reload data:', error);
  }
};

const deleteSelected = async () => {
  const selectedIds = Object.keys(selectedCards).filter((id) => selectedCards[id]);

  if (selectedIds.length > 0) {
    try {
      const response = await axios.post('/deleteItems', { ids: selectedIds });

      if (response.data.message === 'Items deleted successfully') {
        selectedIds.forEach((id) => {
          const index = data.findIndex((item) => item.id.toString() === id);
          if (index !== -1) {
            data.splice(index, 1);
          }
        });

        selectedIds.forEach((id) => {
          selectedCards[id] = false;
        });


      }
    } catch (error) {
      console.error('Error', error);
    }
  }
};
</script>




<style scoped>
  .centered-button {
    text-align: center;
    margin-top: 20px;
  }

  .reload-button {
    background-color: #ebf8ff;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    cursor: pointer;
  }

  .reload-button:hover {
    background-color: #bee3f8;
  }

  .card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    padding: 15px;
  }
  .selected-hobby {
  background-color: #d3d3d3;
}

.unselected-hobby {
  background-color: white;
}

.hobby-item {
  cursor: pointer;
  padding: 8px;
  border-radius: 4px;
  transition: background-color 0.3s;
}

.hobby-item:hover {
  background-color: #e2e8f0;
}
.search-input {
  width: 100%;
  padding: 8px;
  margin: 16px 0;
  font-size: 16px;
  border: 1px solid #d1d5db;
  border-radius: 4px;
}

  </style>
