# Battleship V2+ (CPSC 3750)

This project is a web-based Battleship game built using HTML, CSS, JavaScript, and PHP.

---

Major Iterations

Iteration 1 – Turn-Based Gameplay (Computer Fires Back)

The game was updated so that after the player takes a shot, the computer automatically fires back. This changed the game from single-player clicking into real turn-based gameplay. All hit and miss logic is handled on the server.

Iteration 2 – Server-Controlled Game State

All game data (boards, hits, misses, and statistics) is stored on the server using PHP sessions. The client only sends player actions and displays results. This prevents cheating and keeps the game consistent.

Iteration 3 – Explicit Game State Machine

An explicit game state machine was added on the server using PHP session variables. The game now tracks PLAYER_TURN and COMPUTER_TURN, and all state transitions are enforced by the server. This prevents invalid moves and ensures correct turn order.

---

Known Limitations

AI opponent uses random targeting  
Game state resets when the server stops  
No persistent storage (session-based only)
