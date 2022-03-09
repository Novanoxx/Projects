from graphe import *
from ameliorations import *
import math
import argparse
import os

def charger_donnees(graphe, fichier):
    """
    >>> from graphe import *
    >>> from ameliorations import *
    >>> reseau = Graphe()
    >>> charger_donnees(reseau, "METRO_14.txt")
    >>> sorted(reseau.sommets())
    [1722, 1757, 1869, 1955, 1964, 2068, 1166824, 1166826, 1166828]

    >>> sorted(map(reseau.nom_sommet, reseau.sommets()))
    ['Bercy', 'Bibliothèque-François Mitterrand', 'Châtelet', 'Cour Saint-Emilion', 'Gare de Lyon', 'Madeleine', 'Olympiades', 'Pyramides', 'Saint-Lazare']

    >>> sorted(reseau.aretes())  # doctest: +NORMALIZE_WHITESPACE
    [(1722, 1869, 'METRO_14'), (1757, 1869, 'METRO_14'),
    (1757, 1964, 'METRO_14'), (1955, 1964, 'METRO_14'),
    (1955, 2068, 'METRO_14'), (2068, 1166828, 'METRO_14'),
    (1166824, 1166826, 'METRO_14'), (1166826, 1166828, 'METRO_14')]

    >>> charger_donnees(reseau, "METRO_3b.txt")

    >>> sorted(reseau.sommets())
    [1659, 1718, 1722, 1752, 1757, 1783, 1869, 1955, 1964, 2068, 1166824, 1166826, 1166828]

    >>> sorted(reseau.aretes())  # doctest: +NORMALIZE_WHITESPACE
    [(1659, 1783, 'METRO_3b'), (1718, 1752, 'METRO_3b'),
    (1718, 1783, 'METRO_3b'), (1722, 1869, 'METRO_14'),
    (1757, 1869, 'METRO_14'), (1757, 1964, 'METRO_14'),
    (1955, 1964, 'METRO_14'), (1955, 2068, 'METRO_14'),
    (2068, 1166828, 'METRO_14'), (1166824, 1166826, 'METRO_14'),
    (1166826, 1166828, 'METRO_14')]
    """
    filin = open(fichier, "r")
    file = filin.read().strip()
    file = file.split("#")
    for i in range(len(file)):
    	data_return = file[i].split("\n")
    	for j in range(len(data_return)):
    		if i == 1:
    			data_split = data_return[j].split(":")
    			if len(data_split) < 2:
    				continue
    			graphe.ajouter_sommet(int(data_split[0]), data_split[1])
    		if i == 2:
    			data_split = data_return[j].split("/")
    			if len(data_split) < 3:
    				continue
    			graphe.ajouter_arete(int(data_split[0]), int(data_split[1]), fichier[0:(len(fichier)-4)])

def create_array(graphe, value):
    array = {}
    for i in graphe.sommets():
        array[i] = value
    return array

def numerotations(reseau):
        begin = create_array(reseau, 0)
        parent = create_array(reseau, None)
        ancestor = create_array(reseau, math.inf)
        count = 0
        def num_rec(som):
            nonlocal count, begin, parent, ancestor
            count = count + 1
            begin[som] = ancestor[som] = count
            for t, name in reseau.voisins(som):
                if begin[t] != 0:
                    if parent[som] != t:
                        ancestor[som] = min(ancestor[som], begin[t])
                else:
                    parent[t] = som
                    num_rec(t)
                    ancestor[som] = min(ancestor[som], ancestor[t])
        for v in reseau.sommets():
            if begin[v] == 0:
                num_rec(v)
        return begin, parent, ancestor

def points_articulation(reseau):
    """
    >>> from graphe import *
    >>> from ameliorations import *
    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefghijkl', [None] * 12))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('c', 'a', None), ('c', 'd', None), ('d', 'e', None),
    ...      ('e', 'f', None), ('f', 'd', None), ('a', 'g', None), ('g', 'h', None), ('h', 'a', None),
    ...      ('h', 'i', None), ('i', 'j', None), ('j', 'h', None), ('j', 'k', None), ('k', 'i', None),
    ...      ('i', 'l', None), ('k', 'h', None)])
    >>> sorted(points_articulation(G))
    ['a', 'c', 'd', 'h', 'i']

    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefg', [None] * 7))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('b', 'd', None), ('c', 'd', None), ('d', 'e', None),
    ...      ('d', 'f', None), ('d', 'g', None), ('e', 'f', None), ('f', 'g', None)])
    >>> sorted(points_articulation(G))
    ['b', 'd']

    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefghijklmn', [None] * 14))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('c', 'd', None), ('d', 'a', None), ('c', 'e', None),
    ...      ('e', 'f', None), ('f', 'g', None), ('g', 'h', None), ('g', 'i', None), ('g', 'm', None),
    ...      ('i', 'j', None), ('i', 'k', None), ('k', 'l', None), ('l', 'm', None), ('m', 'n', None),
    ...      ('n', 'l', None)]
    ... )
    >>> sorted(points_articulation(G))
    ['c', 'e', 'f', 'g', 'i']
    """
    articulation = set()
    begin, parent, ancestor = numerotations(reseau)
    root = []
    for v in reseau.sommets():
        if parent[v] == None:
            root.append(v)

    for start in root:
        count = 0
        for child in parent.values():
            if child == start:
                count += 1
        if count >= 2:
            articulation.add(start)
    root.append(None)
    for v in reseau.sommets():
        if (parent[v] not in root) and (ancestor[v] >= begin[parent[v]]):
            articulation.add(parent[v])
    return articulation

def ponts(reseau):
    """
    >>> from graphe import *
    >>> from ameliorations import *
    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefghijkl', [None] * 12))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('c', 'a', None), ('c', 'd', None), ('d', 'e', None),
    ...      ('e', 'f', None), ('f', 'd', None), ('a', 'g', None), ('g', 'h', None), ('h', 'a', None),
    ...      ('h', 'i', None), ('i', 'j', None), ('j', 'h', None), ('j', 'k', None), ('k', 'i', None),
    ...      ('i', 'l', None), ('k', 'h', None)])
    >>> sorted(map(sorted, ponts(G)))
    [['c', 'd'], ['i', 'l']]

    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefg', [None] * 7))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('b', 'd', None), ('c', 'd', None), ('d', 'e', None),
    ...      ('d', 'f', None), ('d', 'g', None), ('e', 'f', None), ('f', 'g', None)])
    >>> sorted(map(sorted, ponts(G)))
    [['a', 'b']]

    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefghijklmn', [None] * 14))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('c', 'd', None), ('d', 'a', None), ('c', 'e', None),
    ...      ('e', 'f', None), ('f', 'g', None), ('g', 'h', None), ('g', 'i', None), ('g', 'm', None),
    ...      ('i', 'j', None), ('i', 'k', None), ('k', 'l', None), ('l', 'm', None), ('m', 'n', None),
    ...      ('n', 'l', None)]
    ... )
    >>> sorted(map(sorted, ponts(G)))
    [['c', 'e'], ['e', 'f'], ['f', 'g'], ['g', 'h'], ['i', 'j']]
    """
    begin, parent, ancestor = numerotations(reseau)
    res = set()
    for u in reseau.sommets():
        v = parent[u]
        if v is not None and ancestor[u] > begin[v]:
            res.add((u, v))
    return res

def amelioration_ponts(reseau) :
    """
    >>> from graphe import *
    >>> from ameliorations import *
    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefghijkl', [None] * 12))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('c', 'a', None), ('c', 'd', None), ('d', 'e', None),
    ...      ('e', 'f', None), ('f', 'd', None), ('a', 'g', None), ('g', 'h', None), ('h', 'a', None),
    ...      ('h', 'i', None), ('i', 'j', None), ('j', 'h', None), ('j', 'k', None), ('k', 'i', None),
    ...      ('i', 'l', None), ('k', 'h', None)])
    >>> for u, v in amelioration_ponts(G):
    ...     G.ajouter_arete(u, v, None)
    >>> len(ponts(G))
    0

    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefg', [None] * 7))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('b', 'd', None), ('c', 'd', None), ('d', 'e', None),
    ...      ('d', 'f', None), ('d', 'g', None), ('e', 'f', None), ('f', 'g', None)])
    >>> for u, v in amelioration_ponts(G):
    ...     G.ajouter_arete(u, v, None)
    >>> len(ponts(G))
    0

    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefghijklmn', [None] * 14))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('c', 'd', None), ('d', 'a', None), ('c', 'e', None),
    ...      ('e', 'f', None), ('f', 'g', None), ('g', 'h', None), ('g', 'i', None), ('g', 'm', None),
    ...      ('i', 'j', None), ('i', 'k', None), ('k', 'l', None), ('l', 'm', None), ('m', 'n', None),
    ...      ('n', 'l', None)]
    ... )
    >>> for u, v in amelioration_ponts(G):
    ...     G.ajouter_arete(u, v, None)
    >>> len(ponts(G))
    0
    """
    def getFirstKey(dico, val):
        """
        Renvoie la première clef dans le dictionnaire ayant pour valeur val
        """
        for item in dico.items():
            if item[1] == val:
                return item[0]
        return None

    def getCSP(reseau):
        """
        Renvoie un dictionnaire spécifiant pour chaque sommet d'un graphe
        la date du représentant de sa CSP.
        """
        begin, _, res = numerotations(reseau)
        def find(x):
            nonlocal begin, res
            if res[x] != res.get(getFirstKey(begin, res[x])):
                res[x] = find(getFirstKey(begin, res[x]))
            return res[x]
        for som in reseau.sommets():
            res[som] = find(som)
        return res

    def leafCSP(bridges, csp):
        """
        Renvoie les dates des représentants d'une CSP qui est une feuille.
        """
        leaf = set()
        node = set()
        for (u, v) in bridges:
            x, y = csp[u], csp[v]
            if x in leaf:
                leaf.remove(x)
                node.add(x)
            elif x not in node:
                leaf.add(x)
            if y in leaf:
                leaf.remove(y)
                node.add(y)
            elif y not in node:
                leaf.add(y)
        return leaf

    def candidats(reseau, ponts, csp, leaves) :
        """
        Renvoie une liste de sommets candidats à être utiliser pour la 
        suppression des ponts.
        """
        res = list()
        choosen = set()
        som_bridges = set(sum(ponts, ()))
        for som in reseau.sommets() :
            if csp[som] in leaves and not csp[som] in choosen :
                if not som in som_bridges or reseau.degre(som) == 1 :
                    res.append(som)
                    choosen.add(csp[som])
            if choosen == leaves :
                break
        return res
    res = set()
    bridges = ponts(reseau)
    csp = getCSP(reseau)
    lst_candidats = candidats(reseau, bridges, csp, leafCSP(bridges, csp))
    for i in range(len(lst_candidats) - 1) :
        res.add((lst_candidats[i], lst_candidats[i + 1]))
    return res

def amelioration_points_articulation(reseau):
    """
    >>> from graphe import *
    >>> from ameliorations import *

    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefghijkl', [None] * 12))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('c', 'a', None), ('c', 'd', None), ('d', 'e', None),
    ...      ('e', 'f', None), ('f', 'd', None), ('a', 'g', None), ('g', 'h', None), ('h', 'a', None),
    ...      ('h', 'i', None), ('i', 'j', None), ('j', 'h', None), ('j', 'k', None), ('k', 'i', None),
    ...      ('i', 'l', None), ('k', 'h', None)])
    >>> for u, v in amelioration_points_articulation(G):
    ...     G.ajouter_arete(u, v, None)
    >>> len(points_articulation(G))
    0

    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefg', [None] * 7))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('b', 'd', None), ('c', 'd', None), ('d', 'e', None),
    ...      ('d', 'f', None), ('d', 'g', None), ('e', 'f', None), ('f', 'g', None)])
    >>> for u, v in amelioration_points_articulation(G):
    ...     G.ajouter_arete(u, v, None)
    >>> len(points_articulation(G))
    0

    >>> G = Graphe()
    >>> G.ajouter_sommets(zip('abcdefghijklmn', [None] * 14))
    >>> G.ajouter_aretes(
    ...     [('a', 'b', None), ('b', 'c', None), ('c', 'd', None), ('d', 'a', None), ('c', 'e', None),
    ...      ('e', 'f', None), ('f', 'g', None), ('g', 'h', None), ('g', 'i', None), ('g', 'm', None),
    ...      ('i', 'j', None), ('i', 'k', None), ('k', 'l', None), ('l', 'm', None), ('m', 'n', None),
    ...      ('n', 'l', None)]
    ... )
    >>> for u, v in amelioration_points_articulation(G):
    ...     G.ajouter_arete(u, v, None)
    >>> len(points_articulation(G))
    0
    """
    begin, parent, ancestor = numerotations(reseau)
    res = []
    roots = []
    for v in reseau.sommets():
        if parent[v] == None:
            roots.append(v)
    points_art = points_articulation(reseau)
    for root in roots:
        if root in points_art:
            for childA in parent:
                for childB in parent:
                    if childA != childB and not reseau.contient_arete(childA, childB) and parent[childA] == parent[childB] == root:
                        res.append((childA, childB))
        for dot in points_art:
            for child in parent:
                if parent[child] == dot and ancestor[dot] == ancestor[parent[child]]:
                    res.append((child, root))
    return res

def test_doctest():
    import doctest
    doctest.testmod()
    print("doctest done")

def main():
    parser = argparse.ArgumentParser()
    group_parser = parser.add_mutually_exclusive_group(required=True)
    group_parser.add_argument(
            "--metro",
            help="Analyse les lignes de métro",
            nargs="*"
        )
    group_parser.add_argument(
            "--rer",
            help="Analyse mes lignes de rer",
            nargs="*"
        )
    parser.add_argument(
            "--l",
            "--liste-stations",
            help="Affiche la liste des stations du réseau",
            action="store_true"
        )
    parser.add_argument(
            "--articulations",
            help="Affiche les points d'articualtion du réseau qui a été chargé",
            action="store_true"
        )
    parser.add_argument(
            "--ponts",
            help="Affiche les ponts du réseau qui a été chargé",
            action="store_true"
        )
    parser.add_argument(
            "--aa",
            "--ameliorer-articulations",
            help="Pareil que --articualtions ainsi que les arêtes a rajouter pour les enlever",
            action="store_true"
        )
    parser.add_argument(
            "--ap",
            "--ameliorer-ponts",
            help="Pareil que --ponts ainsi que les arêtes a rajouter pour les enlever",
            action="store_true"
        )
    args = parser.parse_args()
    reseau = Graphe()
    if args.metro or args.metro == []:
        if len(args.metro) != 0:
            print("Chargement des lignes", args.metro, "de metro ...", end=' ')
            for data in args.metro:
                name = "METRO_" + data + ".txt"
                charger_donnees(reseau, name)
                print("terminé")
        else:
            print("Chargement de toute les lignes de metro ...", end=' ')
            lst = [f for f in os.listdir('.') if os.path.isfile(os.path.join('.', f))]
            for data in lst:
                if "METRO_" in data and ".txt" in data:
                    charger_donnees(reseau, data)
            print("terminé")

        print("Le réseau contient" ,reseau.nombre_sommets(), "sommets et", reseau.nombre_aretes(), "arêtes.")
        print()

    if args.rer or args.rer == []:
        if len(args.rer) != 0:
            print("Chargement des lignes", args.rer, "de rer ...", end=' ')
            for data in args.rer:
                name = "RER_" + data + ".txt"
                charger_donnees(reseau, name)
                print("terminé")
        else:
            print("Chargement de toute les lignes de rer ...", end=' ')
            lst = [f for f in os.listdir('.') if os.path.isfile(os.path.join('.', f))]
            for data in lst:
                if "RER_" in data and ".txt" in data:
                    charger_donnees(reseau, data)
            print("terminé")
        print("Le réseau contient" ,reseau.nombre_sommets(), "sommets et", reseau.nombre_aretes(), "arêtes.")
        print()

    if args.l:
        print("Le réseau contient les", reseau.nombre_sommets(), "stations suivantes:")
        a_afficher = []
        for name in sorted(reseau.sommets()):
            a_afficher.append((reseau.nom_sommet(name), name))
        for name, num in sorted(a_afficher):
            print(name, "(", num, ")")
        print()

    if args.ponts:
        a_afficher = []
        for nameA, nameB in ponts(reseau):
            if reseau.nom_sommet(nameA) < reseau.nom_sommet(nameB):
                a_afficher.append((reseau.nom_sommet(nameA), reseau.nom_sommet(nameB)))
            else:
                a_afficher.append((reseau.nom_sommet(nameB), reseau.nom_sommet(nameA)))
        print("Le réseau contient les", len(a_afficher), "ponts suivants:")
        for nameA, nameB in sorted(a_afficher):
            print("- ", nameA, " -- ", nameB)
        print()

    if args.articulations:
        a_afficher = []
        for name in sorted(points_articulation(reseau)):
            a_afficher.append(reseau.nom_sommet(name))
        a_afficher = sorted(a_afficher)
        print("Le réseau contient les", len(a_afficher), "points d'articulation suivants:")
        for i in range(len(a_afficher)):
            print(i+1, " : ", a_afficher[i])
        print()

    if args.aa:
        a_rajouter = []
        for nameA, nameB in amelioration_points_articulation(reseau):
            if reseau.nom_sommet(nameA) < reseau.nom_sommet(nameB):
                a_rajouter.append((reseau.nom_sommet(nameA), reseau.nom_sommet(nameB)))
            else:
                a_rajouter.append((reseau.nom_sommet(nameB), reseau.nom_sommet(nameA)))
        print("On peut éliminer tous les points d'articulation du réseau en rajoutant les", len(a_rajouter), "arêtes suivantes:")
        for nameA, nameB in a_rajouter:
            print("-", nameA, "--", nameB)
        print()

    if args.ap:
        a_rajouter = []
        for nameA, nameB in amelioration_ponts(reseau):
            if reseau.nom_sommet(nameA) < reseau.nom_sommet(nameB):
                a_rajouter.append((reseau.nom_sommet(nameA), reseau.nom_sommet(nameB)))
            else:
                a_rajouter.append((reseau.nom_sommet(nameB), reseau.nom_sommet(nameA)))
        print("On peut éliminer tous les ponts du réseau en rajoutant les", len(a_rajouter), "arêtes suivantes:")
        for nameA, nameB in sorted(a_rajouter):
            print("-", nameA, "--", nameB)
        print()

if __name__ == "__main__":
    #test_doctest()
    main()