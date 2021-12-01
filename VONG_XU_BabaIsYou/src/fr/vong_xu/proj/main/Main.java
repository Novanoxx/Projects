package fr.vong_xu.proj.main;

import fr.vong_xu.proj.readLevel.ReadLevel;

public class Main {
	public static void main(String[] args) {
			ReadLevel level = new ReadLevel();
			if(args.length < 1){
							level.startLevel("niveau-7");
							return;
					}
			for (int i = 0; i < args.length - 1; i++) {
				if (args[i].equals("--levels")) {
					if (i == args.length - 1) {
						System.out.println("Invalid Argument");
						System.exit(1);
					}
					if (args[i+1].equals("name:")) {
						if(i + 1 == args.length - 1) {
							System.out.println("Invalid Argument");
							System.exit(1);
						}
						level.startLevel(args[i + 2]); // mettre la version pour les dossiers
					}
				}
				if (args[i].equals("--level")) {
					if (args[i + 1].equals("name:")) {
						if (i + 1 == args.length - 1) {
							System.out.println("Invalid Argument");
							System.exit(1);
						}
						level.startLevel(args[i + 2]);
					}
				}
			}
	}
}
