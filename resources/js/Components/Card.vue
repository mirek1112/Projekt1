<template>
    <div
      :class="['card', { selected: isSelected(item.id) }]"
      @click="toggleSelection(item.id, $event)"
    >
      <h2

      >
        {{ item.jmeno }} {{ item.prijmeni }}
      </h2>
      <p

      >
        Birth Date: {{ item.datum }}
      </p>
      <p

      >
        Country: {{ item.country.name }}
      </p>

      <h3  class="card-subtitle">Hobbies:</h3>
      <ul class="card-list" >
        <li
          v-for="hobby in item.hobbies"
          :key="hobby.id"
          :class="{
            'highlighted': selectedHobbies[hobby.name],
            'card-hobby': true
          }"
        >
          {{ hobby.name }}
        </li>
      </ul>
    </div>
  </template>

  <script setup>
   import { reactive } from 'vue';

  const props = defineProps({
    item: {
      type: Object,
      required: true,
    },
    selectedHobbies: {
      type: Object,
      required: true,
    },
    isSelected: {
    type: Boolean,
    required: true,
  },

  });

  const emit = defineEmits(['toggleSelection']);

  const isSelected = (id) => selectedItems[id];
  const selectedItems = reactive({});


  const toggleSelection = (id, event) => {
    emit('toggleSelection');

      if (selectedItems[id]) {
        delete selectedItems[id];
      } else {
        selectedItems[id] = true;
      }
  };

  </script>

  <style scoped>
  .card-hobby {
  margin: 4px 0;
}

.card-hobby.highlighted {
  background-color: yellow;
  border-radius: 4px;
  padding: 2px 4px;
}
  .card {
    flex: 1 1 calc(33.33% - 16px);
    box-sizing: border-box;
    padding: 16px;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .card:hover {
    background-color: #f9fafb;
  }

  .card.selected {
    background-color: #ebf8ff;
    border-color: #93c5fd;
  }

  .highlighted {
    background-color: #1863d4b5;
    transition: background-color 0.3s;
  }

  .card-title {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 8px;
  }

  .card-text {
    margin: 4px 0;
  }

  .card-subtitle {
    margin-top: 16px;
    font-weight: bold;
  }

  .card-list {
    list-style-type: disc;
    padding-left: 16px;
    margin-top: 8px;
  }
  </style>
