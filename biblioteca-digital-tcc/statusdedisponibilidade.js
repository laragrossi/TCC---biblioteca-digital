        //Script para abrir/fechar caixa de notificações -->

        const notificationBtn = document.getElementById('notification-btn'); // Botão do sino
        const notificationBox = document.getElementById('notification-box'); // Caixa de notificações

        // Ao clicar no sino, mostra/esconde a caixa
        notificationBtn.addEventListener('click', () => {
            notificationBox.style.display = notificationBox.style.display === 'block' ? 'none' : 'block';
        });

        // Fecha a caixa se clicar fora dela
        document.addEventListener('click', (event) => {
            if (!notificationBtn.contains(event.target) && !notificationBox.contains(event.target)) {
                notificationBox.style.display = 'none';
            }
        });