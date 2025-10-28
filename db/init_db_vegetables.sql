DROP TABLE IF EXISTS produits;

CREATE TABLE produits (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prix REAL NOT NULL,
    qte INTEGER,
    emoji TEXT
);

INSERT INTO produits (nom, prix, qte, emoji) VALUES
('Pomme', 1.20, 12, '🍎'),
('Banane', 0.80, 15, '🍌'),
('Carotte', 0.50, 18, '🥕'),
('Tomate', 1.10, 23, '🍅'),
('Courgette', 0.90, 8,'🥒'),
('Poivron', 1.50, 20,'🫑'),
('Fraise', 2.30, 6,'🍓'),
('Laitue', 1.00, 16,'🥬'),
('Oignon', 0.60, 37, '🧅'),
('Poire', 1.40, 4,'🍐'),
('Cerise', 2.00, 30,'🍒'),
('Aubergine', 1.80, 12,'🍆'),
('Champignon', 1.20, 16,'🍄'),
('Pomme de terre', 0.70, 29, '🥔'),
('Maïs', 1.10, 4,'🌽'),
('Citron', 1.00, 19,'🍋'),
('Raisin', 2.50, 53,'🍇'),
('Melon', 2.00, 10,'🍈'),
('Pastèque', 2.20, 5,'🍉'),
('Avocat', 1.80, 8,'🥑');
