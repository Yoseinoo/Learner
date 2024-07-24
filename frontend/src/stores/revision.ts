import type { Card } from "@/models/Card";
import axiosInstance from "@/modules/axios";
import { defineStore } from "pinia";
import { ref, type Ref } from "vue";
import { useUsers } from "./user";
import type { Revision } from "@/models/Revision";

export const useRevision = defineStore('revision', () => {
    const userStore = useUsers();

    const revision: Ref<Revision|undefined> = ref(undefined);
    const cardList: Ref<Card[]> = ref([]);
    const currentCard: Ref<Card|undefined> = ref(undefined);
    const cardIndex: Ref<number> = ref(0);

    if (!revision.value) {
        cardIndex.value = 0;
        getRevision();
    }

    function createRevision() {
        console.log("Creating new revision");
        axiosInstance
        .post<Revision>("/api/revision/" +  userStore.authenticatedUser?.id)
        .then(resp => {
            revision.value = resp.data;
            console.log(resp.data);
            getCards();
        })
        .catch(err => console.log("Error creating revision : ", err))
    }

    function getRevision() {
        console.log("Getting revision")
        axiosInstance
        .get<Revision>("/api/revision/" + userStore.authenticatedUser?.id)
        .then(resp => {
            if (!resp.data.id) {
                console.log("No revision found");
                createRevision();
            } else {
                revision.value = resp.data;
                console.log(resp.data);
                getCards();
            }
        })
        .catch(err => console.error("Error getting revision : " + err))
    }

    function getCards() {
        console.log("Get cards to review")
        axiosInstance
        .get<Card[]>("/api/revision/cards/" + userStore.authenticatedUser?.id)
        .then(resp => {
            cardList.value = resp.data;
            nextCard()
            console.log(resp);
        })
        .catch(err => console.error("Error getting cards : " + err))
    }

    function nextCard() {
        if (cardList.value.length == 0 || cardIndex.value >= cardList.value.length) {
            currentCard.value = undefined;
        } else {
            currentCard.value = cardList.value[cardIndex.value++];
        }
    }

    function succeeded() {
        //update card level to next
        if (currentCard.value) {
            currentCard.value.level += 1;
        
            axiosInstance
            .post("/api/card", {
                card: currentCard.value
            })
            .then(resp => {
                console.log('card updated : ', resp.data);
                nextCard();
            })
            .catch(err => console.error("Error saving deck : " + err))
        }
    }

    function failed() {
        //Update card level to 1
        if (currentCard.value) {
          currentCard.value.level = 1;
      
          axiosInstance
          .post("/api/card", {
              card: currentCard.value
          })
          .then(resp => {
              console.log('card updated : ', resp.data);
              nextCard();
          })
          .catch(err => console.error("Error saving deck : " + err))
        }
    }

    return {
        revision,
        cardList,
        currentCard,
        cardIndex,
        succeeded,
        failed
    }
});