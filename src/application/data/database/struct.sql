create table catalogo(
    id_catalogo INTEGER PRIMARY KEY AUTOINCREMENT,
    catalogo VARCHAR(255) NOT NULL,
    fecha DATE NOT NULL
);

create table albumCatalogo(
    id_album INTEGER PRIMARY KEY AUTOINCREMENT,
    id_catalogo INTEGER NOT NULL,
    album VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_catalogo) REFERENCES catalogo(id_catalogo)
);

create table productoAlbum(
    id_producto INTEGER PRIMARY KEY AUTOINCREMENT,
    id_album INTEGER NOT NULL,
    producto VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_album) REFERENCES album(id_album)
);

create table imagenProducto(
    id_imagen INTEGER PRIMARY KEY AUTOINCREMENT,
    id_album INTEGER NOT NULL,
    src VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_album) REFERENCES album(id_album)
);
