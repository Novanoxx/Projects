from upemtk import *

###Tache 1
def lire_grille(nom_fichier):
    '''
    Renvoie une liste de listes decrivant les valeurs d'une cellules de la grille
    Parametre: nom_fichier (str)
    >>>lire_grille(test)
    [[2,2,1,5,3],[2,3,1,4,5],[1,1,1,3,5],[1,3,5,4,2],[5,4,3,2,1]]
    '''
    liste = nom_fichier.split('\n')
    finale = []
    for i in range(len(liste)):
        resultat = []
        nouveau = []
        for elem in liste[i]:
            if elem != ' ':
                resultat.append([elem])
        if len(resultat)%2 == 0:
            for j in range(0,len(resultat),2):
                nouveau += resultat[j] + resultat[j+1]
            finale.append(nouveau)
        else:
            for j in range(0,len(resultat)-1,2):
                nouveau += resultat[j] + resultat[j+1]
            nouveau += resultat[len(resultat)-1]
            finale.append(nouveau)
    w = 1                                               #Check si la grille est valable
    for w in range(len(finale[0])):
        if len(finale[0]) != len(finale[w]):
            return None
    return finale

# test = open('6x6.txt')
# f=test.read()
# print(lire_grille(f))
def affiche_grille(grille):
    '''
    Affiche la grille sur le terminal en fonction de l'argument
    Parametre: grille (lst), plus exactement une liste de listes representant la grille
    
    >>>affiche_grille([[2,2,1,5,3],[2,3,1,4,5],[1,1,1,3,5],[1,3,5,4,2],[5,4,3,2,1]])
     2 | 2 | 1 | 5 | 3
    ---+---+---+---+---
     2 | 3 | 1 | 4 | 5 
    ---+---+---+---+---
     1 | 1 | 1 | 3 | 5 
    ---+---+---+---+---
     1 | 3 | 5 | 4 | 2 
    ---+---+---+---+---
     5 | 4 | 3 | 2 | 1 
    '''
    for ligne in range(len(grille)):
        for colonne in range(len(grille[ligne])):
            if colonne == len(grille[ligne])-1:
                print(' ' + str(grille[ligne][colonne]) + ' ')
            else:
                print(' ' + str(grille[ligne][colonne]) + ' ' + '|',end='')
        if ligne != len(grille) - 1:
            print('---+---+---+---+---')

def ecrire_grille(grille, nom_fichier):
    '''
    Sauvegarde la grille sous forme de liste de listes dans le fichier "nom_fichier"
    Parametre: grille (lst), plus exactement une liste de listes representant la grille
               nom_fichier (str)
               
    fichier = fichier vide
    >>>ecrire_grille([[2,2,1,5,3],[2,3,1,4,5],[1,1,1,3,5],[1,3,5,4,2],[5,4,3,2,1]], fichier)
    2 2 1 5 3
    2 3 1 4 5
    1 1 1 3 5
    1 3 5 4 2
    5 4 3 2 1
    >>>ecrire_grille([[2,2,1,5,3],[2,3,1,4,5],[1,1,1,3,5,4],[1,3,5,4,2],[5,4,3,2,1]], fichier)
    None
    '''
    for ligne in range(len(grille)):
        if len(grille[ligne]) != len(grille):
            return None
        for colonne in grille[ligne]:
            fichier.write(str(colonne) + ' ')
        fichier.write('\n')
    fichier.close()

#fichier = open('fichier.txt','w')
#ecrire_grille([[2,2,1,5,3],[2,3,1,4,5],[1,1,1,3,5],[1,3,5,4,2],[5,4,3,2,1]], fichier)

### Tache 2
def sans_conflit(grille, noircies):
    '''
    Permet de savoir si aucune des cellules visibles de la grille ne contient le même nombre qu’une autre cellule visible située sur la même ligne ou la même colonne
    Parametre: grille (lst), plus exactement une liste de listes representant la grille
               noircies (dict) representant l'ensemble des cases noircies
    Resultat: Renvoie True si la regle ci-dessus est verifiee ,sinon renvoie False
    
    grille = [[2,2,1,5,3],[2,3,1,4,5],[1,1,1,3,5],[1,3,5,4,2],[5,4,3,2,1]]
    >>>sans_conflit(grille, {(2, 0), (0, 0), (3, 3), (2, 2), (3, 1), (0, 2), (1, 4)})
    True
    >>>sans_conflit(grille, {(2, 0), (3, 3), (2, 2), (3, 1), (0, 2), (1, 4)})
    False
    '''
    def grille_Test(grille,noircies):
        '''
        Renvoi une nouvelle liste représentant la grille et où les cases noircies ont la valeur None.
        '''
        for i in range(len(grille)):                                ### Y'avait une incompatibilitée avec ça
            new_Grille.append(grille[i]*1)                          ### Mnt c'est réglé
        for i,j in noircies:
            new_Grille[i][j] = None
        return new_Grille
    
    new_Grille = []                                                 ###
    new_Grille = grille_Test(grille,noircies)

    def test_ligne(new_Grille):
        '''
        Parcours les lignes et renvoi True si il n'y a pas de conflit, False sinon.
        '''
        for list in range(len(new_Grille)):
            for elem in range(1, len(new_Grille[0])):
                for elem2 in range(elem, len(new_Grille[0])):
                    if new_Grille[list][elem-1] == new_Grille[list][elem2] and new_Grille[list][elem2] is not None:
                        return False
        return True
    
    def test_colonne(new_Grille):
        '''
        Parcours les colonnes et renvoi True si il n'y a pas de conflit, False sinon.
        '''
        for elem in range(len(new_Grille[0])):
            for list in range(1, len(new_Grille)):
                for list2 in range(list, len(new_Grille)):
                    if new_Grille[list-1][elem] == new_Grille[list2][elem] and new_Grille[list2][elem] is not None:
                        return False
        return True
        
    ligne = test_ligne(new_Grille)
    colonne = test_colonne(new_Grille)
    
    if ligne is True and colonne is True:
        return True
    else:
        return False

def sans_voisines_noircies(grille, noircies):
    '''
    Permet de savoir si aucune cellule noircie n’est voisine (par un de ses quatre bords)
    Parametre: grille (lst), plus exactement une liste de listes representant la grille
               noircies (dict) representant l'ensemble des cases noircies
    Resultat: Renvoie True si la regle ci-dessus est verifiee ,sinon renvoie False
    
    grille = [[2,2,1,5,3],[2,3,1,4,5],[1,1,1,3,5],[1,3,5,4,2],[5,4,3,2,1]]
    >>>sans_voisines_noircies(grille, {(2, 0), (0, 0), (3, 3), (2, 2), (3, 1), (0, 2), (1, 4)})
    True
    >>>sans_voisines_noircies(grille,{(2, 0), (1, 0)})
    False
    '''
    def grille_Test(grille,noircies):
        '''
        Renvoi une nouvelle liste représentant la grille et où les cases noircies ont la valeur None.
        '''
        for i in range(len(grille)):                                ### Y'avait une incompatibilitée avec ça
            new_Grille.append(grille[i]*1)                          ### Mnt c'est réglé
        for i,j in noircies:
            new_Grille[i][j] = None
        return new_Grille
    
    new_Grille = []                                                 ###
    new_Grille = grille_Test(grille,noircies)
    
    def test_ligne(new_Grille):
        '''
        Parcours les lignes et renvoi True si il n'y a pas au moins deux cases noircies côte à côte, False sinon.
        '''
        for list in range(len(new_Grille)):
            for elem in range(len(new_Grille[0])-1):
                if new_Grille[list][elem] == new_Grille[list][elem+1] and new_Grille[list][elem] is None:
                    return False
        return True
    
    def test_colonne(new_Grille):
        '''
        Parcours les colonnes et renvoi True si il n'y a pas au moins deux cases noircies côte à côte, False sinon.
        '''
        for elem in range(len(new_Grille[0])):
            for list in range(len(new_Grille)-1):
                if new_Grille[list][elem] == new_Grille[list+1][elem] and new_Grille[list][elem] is None:
                    return False
        return True
        
    ligne = test_ligne(new_Grille)
    colonne = test_colonne(new_Grille)
    
    if ligne is True and colonne is True:
        return True
    else:
        return False

def connexe(grille, noircies):
    '''
    Permet de savoir si les cellules visibles de la grille forment une seule zone (ou région ou composante connexe)
    Parametre: grille (lst), plus exactement une liste de listes representant la grille
               noircies (dict) representant l'ensemble des cases noircies
    Resultat: Renvoie True si la regle ci-dessus est verifiee ,sinon renvoie False
    
    grille = [[2,2,1,5,3],[2,3,1,4,5],[1,1,1,3,5],[1,3,5,4,2],[5,4,3,2,1]]
    >>>connexe(grille, {(2, 0), (0, 0), (3, 3), (2, 2), (3, 1), (0, 2), (1, 4)})
    True
    >>>connexe(grille, {(1, 0), (1, 1), (1, 2), (1, 3), (1, 4)})
    False
    '''
    def dans_Grille(grille, i, j):
        """
        Renvoie True si la case (i, j) est une case de la grille, False sinon.
        """
        return (-1 < i < len(grille) and -1 < j < len(grille[i]))
        
    def voisins(i, j):
        """
        Renvoie la liste des voisins du pixel (i, j) (sans prendre en compte les bords).
        """
        return [(i+1,j),(i,j+1),(i-1,j),(i,j-1)]
        
        
    def run_Case(grille,i,j,noircies,s):
        """
        Parcours les cases non noircies et les stock dans un ensemble. Si le nombre d'éléments de l'ensemble est égal au nombre de case non noircies de la grille renvoi True, sinon False
        """
        for elem in voisins(i,j):
            if dans_Grille(grille,elem[0],elem[1]) is True and elem not in noircies and elem not in s:
                s.add(elem)
                run_Case(grille,elem[0],elem[1],noircies,s)
                if len(s) == len(grille)*len(grille[0])-len(noircies):
                    return True
    i,j = 0,0            
    s = set()              
    zone = run_Case(grille,i,j,noircies,s)
    if zone is True:
        return True
    else:
        return False

### Tache 3
## Interface du jeu
def interface():
    '''
    Design la fenetre récemment créer
    '''
    texte(190, 90, "HITORI", taille = 30, tag = "Etape0")
    rectangle(50, 250, 450, 325, epaisseur= 3, tag = "Etape0")
    texte(125, 265, "Lancer une partie", taille = 25, tag = "Etape0")
    rectangle(50, 350, 450, 425,  epaisseur= 3, tag = "Etape0")
    texte(160, 365, "Quitter le jeu", taille = 25, tag = "Etape0")
            
def localisation_clic(CGa, CGb):
    '''
    (FONCTION PRINCIPALE POUR L'INTERFACE)
    Permet de localiser le clic gauche sur l'interface
    Parametre: CGa, CGb (int)
    '''
    global Etape        #Variable permettant de séparer le jeu en plusieurs étapes
    global Jeu          #Gère si le jeu continu ou non
    global Format       #Largeur, hauteur et repère de la grille sélectionnée
    global reset_grille #Sauvegarde de la grille orginale
    global GRILLE       #Sauvegarde de la grille, permet de gérer la grille actuellement lancée
    global reset_clique #Permet que le bouton " Recommencer" fonctionne
    global liste_noire  #Liste comprenant les coordonnées des cases noires
    global sauvegarde   #Liste correspondant à la grille avec un coup(case noire) en moins
    
    def initialisation(inter):
        '''
        Permet d'initialiser toute les informations en rapport avec la grille
        '''
        global reset_grille
        global GRILLE
        fichier = inter.read()
        grille = lire_grille(fichier)
        inter.close()
        for i in range(len(grille)):
            reset_grille.append(grille[i]*1)
        GRILLE = grille
        if grille == None:
            return False
        return grille
        
    if Etape == 0:
        if 50 < CGa < 450 and 250 < CGb < 325:
            ferme_fenetre()
            cree_fenetre(600,600)
            choix_grille()
            Etape += 1
        elif 50 < CGa < 450 and 350 < CGb < 425:
            Jeu = False

    elif Etape == 1:                       
        if 450 < CGa < 575 and 25 < CGb < 140:
            Etape += 0.5
            regle()
        elif 25 < CGa < 575:
            if 150 < CGb < 275:
                Etape += 1
                fichier = open("6x6.txt")
                verification = initialisation(fichier)
                if verification == False:
                    Jeu = False
                    print("La grille n'est pas adapté")
                    return Jeu
                reset_clique = CGb
                Format = interface_grille(verification, CGb, taille_case)
                menu(Format[0], Format[1], Format[2])
            elif 300 < CGb < 425:
                Etape += 1
                fichier = open("7x7.txt")
                verification = initialisation(fichier)
                if verification == False:
                    Jeu = False
                    print("La grille n'est pas adapté")
                    return Jeu
                reset_clique = CGb
                Format = interface_grille(verification, CGb, taille_case)
                menu(Format[0], Format[1], Format[2])
            elif 450 < CGb < 575:
                Etape += 1
                fichier = open("8x8.txt")
                verification = initialisation(fichier)
                if verification == False:
                    Jeu = False
                    print("La grille n'est pas adapté")
                    return Jeu
                reset_clique = CGb
                Format = interface_grille(verification, CGb, taille_case)
                menu(Format[0], Format[1], Format[2])     
            
    elif Etape == 1.5:
        if 445 < CGa < 515 and 10 < CGb < 45:
            Etape -= 0.5
            efface("Regle")
            choix_grille()
    
    elif Etape == 2:                #Commence le jeu
        efface("FAUX")
        if (10*Format[1]//100)//4 < CGb < 13*Format[1]//100:        # Si une des fonctions du menu est choisie
            if Format[0]//16 < CGa < Format[0]//3:           # fonction Quitter
                Jeu = False
                
            elif Format[0]//16 + (Format[0]//2 - (20*Format[0]//100)) < CGa < Format[0]//3 + (Format[0]//2 - (20*Format[0]//100)):                  # fonction Recommencer
                GRILLE = []
                sauvegarde = []
                sauvegarde_noires = set()
                for i in range(len(reset_grille)):
                    GRILLE.append(reset_grille[i]*1)
                liste_noire = set()
                interface_grille(reset_grille, reset_clique, taille_case)
                menu(Format[0], Format[1], Format[2])
                
            elif Format[0]//16 + (Format[0]//2 - (20*Format[0]//100))*2 < CGa < Format[0]//3 + (Format[0]//2 - (20*Format[0]//100))*2:                 # fonction Charger une autre grille
                reset()
                Etape = 1
                ferme_fenetre()
                cree_fenetre(600,600)
                choix_grille()
                
        elif  (200 - Format[2]) < CGa < len(GRILLE)*taille_case + (200 - Format[2]) and 120 < CGb < len(GRILLE)*taille_case + 120:
            # Et si le clique a eu lieu dans la grille
            for ligne in range(len(GRILLE)):
                for colonne in range(len(GRILLE[ligne])):
                    if colonne*taille_case + (200-Format[2]) < CGa < colonne*taille_case + (200-Format[2]) + taille_case and ligne*taille_case + 120 < CGb < ligne*taille_case + 120 + taille_case :
                        grille = noircir_case(GRILLE, ligne, colonne, liste_noire)
                        liste_noire = grille[1]
                        maj_grille(grille[0], taille_case, Format[0], Format[1], Format[2])
                        menu(Format[0], Format[1], Format[2])
                        
        elif Format[0]//20 < CGa < (200-Format[2]) - 20:        # Si une option hors du menu est choisie
            if Format[1]//4 < CGb < Format[1]*3//8:             # fonction annuler
                if  len(sauvegarde) > 0:
                    annuler()
                    maj_grille(GRILLE, taille_case, Format[0], Format[1], Format[2])
                    menu(Format[0], Format[1], Format[2])
                else:
                    pass
            elif Format[1]*7//16 < CGb < Format[1]*7/12:        # fonction victoire
                if victoire(GRILLE, liste_noire) == True:
                    efface_tout()
                    reset()
                    rectangle(0, 0, Format[0], Format[1]//6, remplissage = "black", epaisseur = 2, tag = "grille")
                    texte(Format[0]//6, 50, "VOUS AVEZ GAGNE(E). BRAVO!!", couleur = "white", taille = 25, tag = "VRAI")
                    
                    rectangle(Format[0]//3, Format[1]//4, Format[0]*2//3, Format[1]//2 - 20, "black", "gray", tag = "Etape3")
                    texte(Format[0]//3 + 20, (Format[1]//4 + Format[1]//2 - 20)//2, "Continuer a jouer", couleur = "black", taille = Format[1]//35, tag = "Etape3")
                    rectangle(Format[0]//3, Format[1]//2 + 20, Format[0]*2//3, Format[1]*3//4, "black", "gray", tag = "Etape3")
                    texte(Format[0]//3 + 20, (Format[1]*3//4 + Format[1]//2 + 20)//2, "Quitter", couleur = "black", taille = Format[1]//35, tag = "Etape3")
                    Etape = 3
                else:
                    texte(Format[0]//20, Format[1]*3//4, "FAUX," + str("\n") + "RETENTES :)", couleur = "red", taille = Format[1]//37, tag = "FAUX")
    
    elif Etape == 3:            # Ecran de victoire
        if Format[0]//3 < CGa < Format[0]*2//3:
            if Format[1]//4 < CGb < Format[1]//2 - 20:
                Etape = 1
                efface_tout()
                reset()
                ferme_fenetre()
                cree_fenetre(600, 600)
                choix_grille()
                
            elif Format[1]//2 + 20 < CGb < Format[1]*3//4:
                Jeu = False
                
        

def choix_grille():
    '''
    Interface appliquant le design du menu de sélection
    '''
    rectangle(450, 25, 575, 140, epaisseur = 2, tag = "Etape1")
    texte(460, 40, "Règles" + str("\n") + "du" +  str("\n") + "jeu", taille = 20, tag = "Etape1")
    texte(25, 75, "Quel niveau veux-tu jouer ?", taille = 25, tag = "Etape1")
    rectangle(25, 150, 575, 275, epaisseur = 2, tag = "Etape1")
    texte(50, 200, "Grille 6x6             niveau facile", taille = 25, tag = "Etape1")
    rectangle(25, 300, 575, 425, epaisseur = 2, tag = "Etape1")
    texte(50, 350, "Grille 7x7             niveau moyen", taille = 25, tag = "Etape1")
    rectangle(25, 450, 575, 575, epaisseur = 2, tag = "Etape1")
    texte(50, 500, "Grille 8x8             niveau difficile", taille = 25, tag = "Etape1")

def regle():
    '''
    Affiche les règles du jeu
    '''
    efface("Etape1")
    image(300, 300, "Regle.PNG",tag = "Regle")
    rectangle(445, 10, 515, 45, epaisseur = 2, tag = "Regle")
    texte(450, 15, "Retour", taille = 15, tag = "Regle")

def interface_grille(liste, CGb, taille_case):
    '''
    Créer la grille sélectionné
    '''
    ferme_fenetre()
    if 150 < CGb < 275:
        largeur = 700
        hauteur = 600
        repere = 0                       # Repere pour les emplacements
    elif 300 < CGb < 425:
        largeur = 750
        hauteur = 650
        repere = 4
    elif 450 < CGb < 575:
        largeur = 800
        hauteur = 700
        repere = 8
    cree_fenetre(largeur, hauteur)
    maj_grille(liste, taille_case, largeur, hauteur, repere)
    return largeur, hauteur, repere         #Format[0], Format[1], Format[2]

def maj_grille(liste, taille_case, largeur, hauteur, repere):
    '''
    Met a jour la grille
    '''
    efface("Etape2")
    rectangle(0, 0, largeur, hauteur//6, remplissage = "black", epaisseur = 2, tag = "Etape2")
    for ligne in range(len(liste)):
        for colonne in range(len(liste[ligne])):
            if liste[ligne][colonne] == 'N':
                rectangle(colonne*taille_case + (200-repere), ligne*taille_case + 120, colonne*taille_case + (200-repere) + taille_case, ligne*taille_case + 120 + taille_case, remplissage = "black", tag = "Etape2")
            else:
                rectangle(colonne*taille_case + (200-repere), ligne*taille_case + 120, colonne*taille_case + (200-repere) + taille_case, ligne*taille_case + 120 + taille_case, remplissage = "white", tag = "Etape2")
            texte(colonne*taille_case +(228-repere), ligne*taille_case + (140-repere), liste[ligne][colonne], taille = 20, tag = "Etape2")

def menu(largeur, hauteur, repere):
    '''
    En fonction de la largeur et de la hauteur de la fenetre, affiche un menu permanent:
    Quitter, recommencer et charger une autre grille
    '''
    for i in range (3):
        rectangle(largeur//16 + (largeur//2 - (20*largeur//100))*i,(10*hauteur//100)//4 , largeur//3 + (largeur//2 - (20*largeur//100))*i, 13*hauteur//100, remplissage = 'gray', tag = "Menu")
    texte(largeur//16 + (9*largeur//128), (20*hauteur//100)//4, "Quitter", taille = hauteur//35, tag = "Menu")
    texte(largeur//16 + (largeur//2 - (20*largeur//100)) + (9*largeur//256), (20*hauteur//100)//4, "Recommencer", taille = hauteur//35, tag = "Menu")
    texte(largeur//16 + (largeur//2 - (20*largeur//100))*2 + (9*largeur//256), (15*hauteur//100)//4, "Charger une" + str('\n') + "autre grille", taille = hauteur//35, tag = "Menu")
    rectangle(largeur//20, hauteur//4, (200-repere) - 20, hauteur*3//8, remplissage = 'gray', tag = "Menu")
    rectangle(largeur//20, hauteur*7//16, (200-repere) - 20, hauteur*7//12, remplissage = 'gray', tag = "Menu")
    texte(largeur//13, hauteur*2//7, "Annuler le" + str("\n") + "dernier coup", taille = hauteur//46, tag = "Menu")
    texte(largeur//13, hauteur*15//32, "Valider la"+ str("\n") + "grille", taille = hauteur//42, tag = "Menu")
    

## Moteur du jeu

def reset():
    '''
    Fonction permettant de reinitialiser toute information ayant un rapport avec les informations dans la grille
    '''
    global sauvegarde
    global GRILLE
    global liste_noire
    global reset_grille
    sauvegarde = []
    GRILLE = []
    sauvegarde_noires = set()
    liste_noire = set()
    reset_grille = []
    
def noircir_case(liste, ligne, colonne, liste_noire):
    '''
    Fonction permettant de noircir la case sélectionné
    '''
    global sauvegarde
    global sauvegarde_noires
    if (ligne, colonne) in liste_noire:
        pass
    else:
        sauvegarde = []
        sauvegarde_noires = set(liste_noire)
        liste_noire.add((ligne, colonne))
        for i in range(len(liste)):
            sauvegarde.append(liste[i]*1)
        liste[ligne][colonne] = 'N'
    return liste, liste_noire
    

def annuler():
    '''
    Fonction permettant de revenir en arrière d’un coup.
    '''
    global GRILLE
    global sauvegarde
    global sauvegarde_noires
    global liste_noire
    GRILLE = sauvegarde
    if len(liste_noire) > 0:
        liste_noire = set(sauvegarde_noires)
    
def victoire(grille, liste_noire):
    '''
    Fonction verifiant si la grille est correct ou non
    '''
    if sans_conflit(grille, liste_noire) == True and sans_voisines_noircies(grille, liste_noire) == True and connexe(grille, liste_noire) == True:
        return True
    else:
        return False
        

### Tache 4 # Le programme de la tache 4 ne marche pas mais il est laissé pour montrer ce que nous avons pu faire

def resoudre(grille,i,j,noircies):
    '''considère chaque cellule une par une, et explore récursivement le reste de la grille, d’abord en
supposant que cette cellule est noircie, puis qu’elle reste visible.'''

    def test_ligne(grille,i,j):
        '''vérifie si la case i,j n'est égal à aucune autre case de la ligne'''
        if j == 0:
            for elem in range(1,len(grille[0])):
                if grille[i][elem] == grille[i][j]:
                    return grille[i][elem]
            return True
        elif j == len(grille[0])-1:
            for elem in range(j):
                if grille[i][elem] == grille[i][j]:
                    return grille[i][elem]
            return True
        else:
            for elem in range(j):
                if grille[i][elem] == grille[i][j]:
                    return grille[i][elem]
            for elem in range(j+1,len(grille[0])):
                if grille[i][elem] == grille[i][j]:
                    return grille[i][elem]
            return True
            
    def test_colonne(grille,i,j):
        '''vérifie si la case i,j n'est égal à aucune autre case de la colonne'''
        if i == 0:
            for elem in range(1,len(grille)):
                if grille[elem][j] == grille[i][j]:
                    return grille[elem][j]
            return True
        elif i == len(grille)-1:
            for elem in range(i):
                if grille[elem][j] == grille[i][j]:
                    return grille[elem][j]
            return True
        else:
            for elem in range(i):
                if grille[elem][j] == grille[i][j]:
                    return grille[elem][j]
            for elem in range(i+1,len(grille)):
                if grille[elem][j] == grille[i][j]:
                    return grille[elem][j]
            return True

    if sans_voisines_noircies(grille, noircies) is False or connexe(grille, noircies) is False:
        return None
    if sans_conflit(grille, noircies) is True and sans_voisines_noircies(grille, noircies) is True and connexe(grille, noircies) is True:
        return noircies
    elif sans_conflit(grille, noircies) is False and sans_voisines_noircies(grille, noircies) is True and connexe(grille, noircies) is True:
        if test_ligne(grille,i,j) is True and test_colonne(grille,i,j) is True:
            if j != len(grille[0])-1:
                resoudre(grille,i,j+1,noircies)
            else: 
                resoudre(grille,i+1,0,noircies)
        else:
            avant = noircies
            noircies.add((i,j))
            if j == len(grille[0])-1:
                suivant = resoudre(grille, i+1, 0, noircies)
            else:
                suivant = resoudre(grille, i, j+1, noircies)
            if suivant == noircies:
                return suivant
            else:
                noircies = avant
                if j == len(grille[0])-1:
                    suivant = resoudre(grille, i+1, 0, noircies)
                else:
                    suivant = resoudre(grille, i, j+1, noircies)
                if suivant == noircies:
                    return suivant
                else:
                    return None

### Main
if __name__ == "__main__":
    i,j = 0,0      #Variables utilé pour la tache 4
    #Variable globale
    Jeu = True
    Etape = 0
    Format = (0,0)
    reset_grille = []
    GRILLE = []
    liste_noire = set()
    reset_clique = None
    sauvegarde = []
    sauvegarde_noires = set()
    #
    cree_fenetre(500,500)
    taille_case = 70
    interface()
    while Jeu:
        Evenement = donne_ev()
        TEvenement = type_ev(Evenement)
        if TEvenement == 'Quitte':
            Jeu = False
        if TEvenement == 'ClicGauche':
            CGa, CGb = (abscisse(Evenement), ordonnee(Evenement))
            localisation_clic(CGa, CGb)
        mise_a_jour()
    ferme_fenetre()