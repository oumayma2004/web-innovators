const chat = document.getElementById("chat");

function appendMessage(from, text) {
  const msg = document.createElement("p");
  msg.innerHTML = `<strong>${from}:</strong> ${text}`;
  chat.appendChild(msg);
  chat.scrollTop = chat.scrollHeight;
}

function speak(text) {
  const utterance = new SpeechSynthesisUtterance(text);
  utterance.lang = "fr-FR";
  speechSynthesis.speak(utterance);
}

function startListening() {
  const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
  recognition.lang = "fr-FR";
  recognition.start();

  recognition.onresult = async function (event) {
    const userText = event.results[0][0].transcript;
    appendMessage("Vous", userText);

    const botText = await getAIResponse(userText);
    appendMessage("Bot", botText);
    speak(botText);
  };

  recognition.onerror = function (event) {
    appendMessage("Erreur", event.error);
  };
}

// Analyse simple des intentions
function getLocalResponse(text) {
  const message = text.toLowerCase();

  if (message.includes("bonjour") || message.includes("salut")) {
    return "Bonjour ! Comment puis-je vous aider aujourd’hui ?";
  }
  if (message.includes("événement")) {
    return "Le prochain événement est un concert samedi à 20h au théâtre municipal.";
  }
  if (message.includes("réserver") || message.includes("réservation")) {
    return "Vous pouvez réserver directement sur la page 'Événements' de notre site.";
  }
  if (message.includes("heure") || message.includes("horaire")) {
    return "Les événements commencent généralement à 20h.";
  }
  if (message.includes("lieu") || message.includes("où")) {
    return "L'événement se déroulera au centre culturel de la ville.";
  }
  if (message.includes("merci")) {
    return "Avec plaisir ! 😊";
  }
  return null; // Si aucune réponse locale
}

async function getAIResponse(text) {
  const localResponse = getLocalResponse(text);
  if (localResponse) return localResponse;

  // Appel serveur IA sinon
  try {
    const response = await fetch("http://localhost:3000/chat", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ text })
    });
    const data = await response.json();
    return data.response || "Je n'ai pas trouvé de réponse exacte, mais je peux vous aider autrement.";
  } catch (e) {
    return "Désolé, je ne peux pas contacter le serveur pour l’instant. Essayez plus tard.";
  }
}
