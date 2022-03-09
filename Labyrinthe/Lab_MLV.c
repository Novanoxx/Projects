#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <unistd.h>
#include <MLV/MLV_all.h>

/*Pour éviter d'avoir une fenetre qui depasse l'ecran*/
#define HAUTEUR 800
#define LARGEUR 800

typedef struct {
	int x;	
	int y;
} Case;

typedef struct {
	int mur_hori;
	int mur_vert;
} Labyrinthe;


/* Fonction qui initialise les tableaux 
peres et rang,où chaque case appartient 
à sa propre case et donc leurs rangs vaut 1 */

Case ** Init_peres(Case **peres, int hauteur, int largeur) {
	int i, j;
	Case cellule;

	i = 0;
	peres = (Case **) malloc(sizeof(Case *) * hauteur);

	for (; i != hauteur; i++) {
		j = 0;
		peres[i] = (Case *) malloc(sizeof(Case ) * largeur);
		for (; j != largeur; j++) {
			cellule.x = i;
			cellule.y = j;
			peres[i][j] = cellule;
		}
	}

	return peres;
}


int ** Init_rang(int **rang, int hauteur, int largeur) {
	int i, j;

	rang = (int **) malloc(sizeof(int *) * hauteur);
	i = 0;

	for (; i != hauteur; i++) {
		rang[i] = (int *) malloc(sizeof(int) * largeur);
		j = 0;
		for (; j != largeur; j++) {
			rang[i][j] = 1;
		}
	}

	return rang;
}


Labyrinthe ** Init_laby(Labyrinthe **laby, int hauteur, int largeur) {
	int i, j;

	laby = (Labyrinthe **) malloc(sizeof(Labyrinthe *) * hauteur);
	i = 0;

	for (; i != hauteur; i++) {
		laby[i] = (Labyrinthe *) malloc(sizeof(Labyrinthe) * largeur);
		j = 0;
		for (; j != largeur; j++) {
			laby[i][j].mur_hori = 1;
			laby[i][j].mur_vert = 1;
		}
	}
	laby[i - 1][j - 1].mur_vert = 0; 
	return laby;
}

Case TrouveCompresse(Case **peres, Case cellule){
	if((peres[cellule.x][cellule.y].x != cellule.x) || (peres[cellule.x][cellule.y].y != cellule.y)) {
		peres[cellule.x][cellule.y] = TrouveCompresse(peres, peres[cellule.x][cellule.y]);
	}

	return peres[cellule.x][cellule.y];
}


/* Fonction qui retourne 1 si deux cases sont dans la même
classe
(utilisee pour regarder si l'origine et la fin sont dans la meme classe)*/
int Classe_identique(Case **peres, Case celluleA, Case celluleB) {
	Case reprA, reprB;

	reprA = TrouveCompresse(peres, celluleA);
	reprB = TrouveCompresse(peres, celluleB);

	if (reprA.x == reprB.x && reprA.y == reprB.y)
		return 1;
	return 0;
}

void FusionRang(Case **peres, int **rang, Case celluleA, Case celluleB) {
	Case reprA, reprB;

	reprA = TrouveCompresse(peres, celluleA);
    reprB = TrouveCompresse(peres, celluleB);

    if(reprA.x != reprB.x || reprA.y != reprB.y) {
	    if (rang[reprA.x][reprA.y] >= rang[reprB.x][reprB.y]) {
	    	peres[reprB.x][reprB.y] = reprA;
	    	if (rang[reprA.x][reprA.y] == rang[reprB.x][reprB.y])
	    		rang[reprA.x][reprA.y] += 1;
	    }
	    else
	    	peres[reprA.x][reprA.y] = reprB;
	}
}


void Affichage_graph(Labyrinthe **laby, int hauteur, int largeur) {
	int i, j;
	int taille_x, taille_y;

	i = 0;
	taille_x = HAUTEUR / largeur;
	taille_y = LARGEUR / hauteur;

	/*Trace la ligne horizontale haut*/
	MLV_draw_line(0, 0, (largeur * taille_x), 0, MLV_COLOR_SALMON);
	/*Trace la ligne verticale gauche*/
	MLV_draw_line(0, taille_y, 0, (hauteur * taille_y), MLV_COLOR_SALMON);
	/*Trace la ligne horizontale bas*/
	MLV_draw_line(0, (hauteur * taille_y) - 1, (largeur * taille_x), (hauteur * taille_y) - 1, MLV_COLOR_SALMON);
	/*Trace la ligne verticale droite*/
	MLV_draw_line((largeur * taille_x) - 1, ((hauteur -1 ) * taille_y), (largeur * taille_x) - 1, 0, MLV_COLOR_SALMON);

	for (; i != hauteur * taille_y; i += taille_y){
		j = 0;
		for (; j != largeur * taille_x; j += taille_x) {
			if (laby[i/taille_y][j/taille_x].mur_hori == 1)
				MLV_draw_line(j, i + taille_y, (j + 1) + taille_x, i + taille_y, MLV_COLOR_SALMON);
			if (laby[i/taille_y][j/taille_x].mur_vert == 1)
				MLV_draw_line(j + taille_x, i, j + taille_x, (i + 1) + taille_y, MLV_COLOR_SALMON);	
		}
	}
	MLV_actualise_window();
}

void Affichage_console(Labyrinthe **laby, int hauteur, int largeur){
	int i, j;
	/*Affiche la ligne horizontale haut*/
	for(j = 0; j < largeur; j++){
		printf("+--");
	}
	printf("+\n");
	for (i = 0; i < hauteur; i++){
		/*Affiche la ligne verticale gauche*/
		if (i == 0 && j != 0)
			printf("   ");
		else
			printf("|  ");
		//
		for (j = 0; j < largeur - 1; j++){
			if (laby[i][j].mur_vert == 1)
				printf("|  ");
			else
				printf("   ");
		}
		/*Affiche la ligne verticale droite*/
		if (i == hauteur - 1 && j == largeur - 1)
			printf("\n");
		else
			printf("|\n");
		//
		for (j = 0; j < largeur; j++){
			printf("+");
			if (laby[i][j].mur_hori == 1)
				printf("--");
			else
				printf("  ");
		}
		printf("+\n");
	}
}

int est_entier(char *mot, int taille){
	int i;

	i = 0;

	for (; i < taille; i++){
		if (mot[i] < '0' || mot[i] > '9'){
			return 0;
		}
	}
	return 1;
}

int taille_valide(char *argv[], int *hauteur, int *largeur, char argument[10], int i, int j){
	char entier_gauche[4], entier_droite[4];
	int w, z;

	w = i;
	z = 0;

	if (strcmp(argument, "--taille=") == 0) {
		z = 0;
		while (argv[j][w] != 'x') {
			entier_gauche[z] = argv[j][w];
			w += 1;
			z += 1;
		}

		z = 0;
		while (argv[j][w + 1] != '\0') {
			entier_droite[z] = argv[j][w + 1];
			w += 1;
			z += 1;
		}
	}
	if (est_entier(entier_gauche, strlen(entier_gauche)) == 1 && est_entier(entier_droite, strlen(entier_droite)) == 1 ){
		*hauteur = atoi(entier_gauche);
		*largeur = atoi(entier_droite);
		return 1;
	}
	fprintf(stderr, "Erreur dans l'argument de taille\n");
	return 0;
}

int graine_valide(char *argv[], int *graine, char argument[10], int i, int j){
	char entier_test[10];
	int w, z;

	w = i;
	z = 0;

	if (strcmp(argument, "--graine=") == 0){
		while(argv[j][w] != '\0'){
			entier_test[z] = argv[j][w];
			w += 1;
			z += 1;
		}
		printf("%s\n", entier_test);
		if (est_entier(entier_test, strlen(entier_test) - 1) == 0){
			fprintf(stderr, "Erreur dans l'argument de graine\n");
			return 0;
		}
	}
	*graine = atoi(entier_test);
	return 1;
}

int attente_valide(char *argv[], int *attente, char argument[10], int i, int j){
	char entier_test[10];
	int w, z;

	w = i;
	z = 0;

	if (strcmp(argument, "--attente=") == 0){
		while(argv[j][w] != '\0'){
			entier_test[z] = argv[j][w];
			w += 1;
			z += 1;
		}
		if (est_entier(entier_test, strlen(entier_test) - 1) == 0){
			fprintf(stderr, "Erreur dans l'argument de attente\n");
			return 0;
		}
	}
	*attente = atoi(entier_test);
	return 1;
}

void suppression_alea(Labyrinthe **laby, Case **peres, int **rang, int mode, int hauteur, int largeur, int attente){
	MLV_Keyboard_button touche;
	int check;						/*check regarde les murs, 0 = horizontale, 1 = verticale*/
	Case coord_A, coord_B;
	Case entree, sortie;
	
	entree.x = 0;
    entree.y = 0;
    sortie.x = (hauteur - 1);
    sortie.y = (largeur - 1);

	while (Classe_identique(peres, entree, sortie) == 0) {
    	coord_A.x = rand() % hauteur;
    	coord_A.y = rand() % largeur;
		check = rand() % 2;

		if (coord_A.x == (hauteur - 1) && coord_A.y == (largeur - 1) && check == 0)
			coord_A.x -= 1;

		else if (coord_A.x == (hauteur - 1) && coord_A.y == (largeur - 1) && check == 1)
			coord_A.y -= 1;

		if (check == 0 && coord_A.x == (hauteur - 1))
			check = 1;

		if (check == 1 && coord_A.y == (largeur - 1))
			check = 0;
		
		if (check == 0){
			laby[coord_A.x][coord_A.y].mur_hori = 0;
			coord_B.x = coord_A.x + 1;
			coord_B.y = coord_A.y;
		}
		else{
			laby[coord_A.x][coord_A.y].mur_vert = 0;
			coord_B.x = coord_A.x;
			coord_B.y = coord_A.y + 1;
		}
    	TrouveCompresse(peres, coord_A);
    	FusionRang(peres, rang, coord_A, coord_B);

    	if (mode == 0){
    		if (attente <= -1){
    			Affichage_console(laby, hauteur, largeur);
				fprintf(stderr, "\n\n");
				getchar();
    		}
    		else if (attente > 0){
    			Affichage_console(laby, hauteur, largeur);
    			fprintf(stderr, "\n\n");
    			usleep(attente * 1000);
    		}
    	}
		else {
			if (attente <= -1){
				MLV_wait_keyboard(&touche, NULL, NULL);
				MLV_clear_window(MLV_COLOR_BLACK);
				Affichage_graph(laby, hauteur, largeur);
			}
			else if (attente > 0){
				MLV_wait_milliseconds(attente);
	    		MLV_clear_window(MLV_COLOR_BLACK);
				Affichage_graph(laby, hauteur, largeur);
			}	
		}
    }
}

int main(int argc, char * argv[]) {
	int hauteur, largeur, mode, i, j, graine, attente;
	char argument[10];

	hauteur = 6;
    largeur = 8;
    graine = time(NULL);
    attente = -1;
    mode = 1;
    int **rang = NULL;
    Labyrinthe **laby = NULL;
    Case **peres = NULL;
    j = 1;
    if (argc >= 2){
    	for (; j < argc; j++){
		    if (strcmp(argv[j], "--mode=texte") == 0)
	    		mode = 0;
    	}

    	j = 1;
    	for (; j < argc; j++){
    		i = 0;
			for (; argv[j][i - 1] != '='; i++) {
		    	argument[i] = argv[j][i];
		    }
    		if (strcmp(argument, "--graine=") == 0){
    			if (graine_valide(argv, &graine, argument, i, j) == 0)
    				return 0;
    		}
    		else if (strcmp(argument, "--attente=") == 0){
    			if (attente_valide(argv, &attente, argument, i, j) == 0)
    				return 0;
    		}
    		else if (strcmp(argument, "--taille=") == 0){
    			if (taille_valide(argv, &hauteur, &largeur, argument, i, j) == 0)
					return 0;
    		}
    		memset(argument, 0, 10);
    	}
    }
    peres = Init_peres(peres, hauteur, largeur);
    rang = Init_rang(rang, hauteur, largeur);
    laby = Init_laby(laby, hauteur, largeur);
    srand(graine);

    if (mode == 1){
    	MLV_create_window("Version graphique","Labyrinthe", HAUTEUR, LARGEUR);
    	Affichage_graph(laby, hauteur, largeur);
    	MLV_actualise_window();
    }
    suppression_alea(laby, peres, rang, mode, hauteur, largeur, attente);
    if (mode == 0)
    	Affichage_console(laby, hauteur, largeur);
    else if (mode == 1){
    	MLV_clear_window(MLV_COLOR_BLACK);
    	Affichage_graph(laby, hauteur, largeur);
    	MLV_actualise_window();
    	MLV_wait_seconds(5);
    	MLV_free_window();
    }

    return 0;
}
