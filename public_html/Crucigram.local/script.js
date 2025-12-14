const crosswordContainer = document.getElementById('crossword-container');
const acrossCluesList = document.getElementById('across-clues');
const downCluesList = document.getElementById('down-clues');


function loadCrosswordData() {
    fetch('datos.json')
        .then(response => response.json())
        .then(data => {
            generateGrid(data.words);
            displayClues(data.words);
        })
        .catch(error => console.error('Error loading data:', error));
}

function generateGrid(words) {
    // Determine grid size based on word positions.  This is overly simplistic.
    let maxRow = 0;
    let maxCol = 0;
    words.forEach(word => {
      maxRow = Math.max(maxRow, word.row);
      maxCol = Math.max(maxCol, word.col);
      
      if (word.dir === "H") {
        maxCol = Math.max(maxCol, word.col + word.word.length -1);
      } else {
         maxRow = Math.max(maxRow, word.row + word.word.length -1);
      }
    });
    
    const gridSize = Math.max(maxRow, maxCol) + 1;

    crosswordContainer.style.gridTemplateColumns = `repeat(${gridSize}, 30px)`;

    // Create empty grid
    const gridData = Array(gridSize).fill(null).map(() => Array(gridSize).fill(null));

    // Place words in the grid
    words.forEach(word => {
        for (let i = 0; i < word.word.length; i++) {
            const row = word.row + (word.dir === 'V' ? i : 0);
            const col = word.col + (word.dir === 'H' ? i : 0);
            gridData[row][col] = {
                letter: word.word[i],
                clueNumber: (i === 0) ? word.number : null
            };
        }
    });

    // Create HTML grid
    for (let i = 0; i < gridSize; i++) {
        for (let j = 0; j < gridSize; j++) {
            const cellWrapper = document.createElement('div');
            cellWrapper.classList.add('cell-wrapper');

            const cell = document.createElement('input');
            cell.type = 'text';
            cell.maxLength = '1';
            cell.classList.add('crossword-cell');

            if (gridData[i][j]) {
                cell.dataset.row = i;
                cell.dataset.col = j;

                if (gridData[i][j].clueNumber) {
                    cell.dataset.clueNumber = gridData[i][j].clueNumber;
                    const clueNumberSpan = document.createElement('span');
                    clueNumberSpan.classList.add('clue-number');
                    clueNumberSpan.textContent = gridData[i][j].clueNumber;
                    cellWrapper.appendChild(clueNumberSpan);
                }
                cellWrapper.appendChild(cell);

            } else {
                cell.classList.add('black-cell');
                cell.disabled = true;
                cellWrapper.appendChild(cell);
            }

            crosswordContainer.appendChild(cellWrapper);
        }
    }
}

function displayClues(words) {
    const acrossClues = words.filter(word => word.dir === 'H');
    const downClues = words.filter(word => word.dir === 'V');

    acrossClues.forEach(word => {
        const listItem = document.createElement('li');
        listItem.textContent = `${word.number}. ${word.clue}`;
        acrossCluesList.appendChild(listItem);
    });

    downClues.forEach(word => {
        const listItem = document.createElement('li');
        listItem.textContent = `${word.number}. ${word.clue}`;
        downCluesList.appendChild(listItem);
    });
}

// Call the function to load data and generate the grid


const checkAnswersButton = document.getElementById('check-answers');
=======
loadCrosswordData();

const checkAnswersButton = document.getElementById('check-answers');

const checkAnswersButton = document.getElementById('check-answers');

checkAnswersButton.addEventListener('click', () => {
    // Implementa la lógica para comparar la entrada del usuario con las respuestas correctas
    // y proporciona retroalimentación.
});