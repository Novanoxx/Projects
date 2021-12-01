package fr.vong_xu.proj.readLevel;

import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.geom.Rectangle2D;
import java.io.IOException;
import java.nio.file.FileSystems;
import java.nio.file.Files;
import java.util.ArrayList;
import java.util.List;
import java.util.Objects;

import fr.umlv.zen5.Application;
import fr.umlv.zen5.ApplicationContext;
import fr.umlv.zen5.Event;
import fr.umlv.zen5.KeyboardKey;
import fr.umlv.zen5.ScreenInfo;
import fr.vong_xu.proj.board.Board;
import fr.vong_xu.proj.entity.BiYBlock;
import fr.vong_xu.proj.entity.BiYBlockType;
import fr.vong_xu.proj.entity.BiYConditions;
import fr.vong_xu.proj.entity.BiYMove;

public class ReadLevel {
	private List<String> lines = new ArrayList<>();
	private static final List<BiYBlock> remove_list = new ArrayList<>();
	private final List<BiYBlock> win_list = new ArrayList<>();
	private final List<BiYBlock> sink_list = new ArrayList<>();
	private final List<BiYBlock> defeat_list = new ArrayList<>();
	private final List<BiYBlock> hot_list = new ArrayList<>();

	/**
	 * Getter of remove_list
	 * 
	 * @return
	 */
	public static List<BiYBlock> getRemove() {
		return remove_list;
	}
	
	/**
	 * Load a level
	 * 
	 * @param fname the name of the file
	 * @param level the level chosen
	 * @return void
	 */
	private void level(String fname, int level) {
		if (fname.startsWith("niveau")) {
			try {
				lines = Files.readAllLines(FileSystems.getDefault().getPath("resource","level", fname + ".txt"));
			} catch (IOException e) {
				e.printStackTrace();
			}
		} else {
			try {
				lines = Files.readAllLines(FileSystems.getDefault().getPath(fname, "niveau-" + level + ".txt"));
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
	}
	
	/**
	 * Set the board thanks to the file given before
	 * 
	 * @param board the game board
	 * @return void
	 */
	private void setBoard(Board board) {
		for (String line : lines){
			String[] arrayOfLine = line.split(" ");
			switch (arrayOfLine[0]) {
	        	case "setx" -> board.setSquareX(Integer.parseInt(arrayOfLine[1]));
	        	case "sety" -> board.setSquareY(Integer.parseInt(arrayOfLine[1]));
	        	case "." ->  board.add(Board.getBlockList(), new BiYBlock(Integer.parseInt(arrayOfLine[1]), Integer.parseInt(arrayOfLine[2]), StringToEnum(arrayOfLine[3]), Boolean.parseBoolean(arrayOfLine[4])));
	        	default -> throw new IllegalArgumentException("Level file not valid !");
	        }
		}
	}
	
	/**
	 * Draw the game board
	 * 
	 * @param graphics the context used
	 * @param board the game board
	 * @param win_list the list which have all the win block
	 * @param sink_list the list which have all the sink block
	 * @param defeat_list the list which have all the defeat block
	 * @param remove_list the list which have all the remove block
	 * @return void
	 */
	private void drawBoard(Graphics2D graphics, Board board, List<BiYBlock> win_list, List<BiYBlock> sink_list, List<BiYBlock> defeat_list, List<BiYBlock> remove_list) {
		graphics.setColor(Color.BLACK);
		graphics.fill(new  Rectangle2D.Float(0, 0, board.width() + 100, board.height() + 100));
		for (BiYBlock block : Board.getBlockList()) {
			block.draw(graphics, board);
			block.resetAllProperty();
			block.leftRightProperty(board);
			block.upDownProperty(board);
		}
		win_list.clear();
		sink_list.clear();
		defeat_list.clear();
		remove_list.clear();
	}
	
	/**
	 * Set all the properties for all of the blocks in the game board and fill the list given
	 * 
	 * @param board the game board
	 * @param win_list the list which have all the win block
	 * @param sink_list the list which have all the sink block
	 * @param defeat_list the list which have all the defeat block
	 * @param hot_list the list which have all the hot block
	 * @return void
	 */
	private void setBlockProp(Board board, List<BiYBlock> win_list, List<BiYBlock> sink_list, List<BiYBlock> defeat_list, List<BiYBlock> hot_list) {
		for (BiYBlock block : Board.getBlockList()) {
			block.leftRightProperty(board);
			block.upDownProperty(board);
			if (block.isText() || block.getType() == BiYBlockType.IS || block.isProperty())
				block.setPush(true);
			if (block.isWin())
				win_list.add(block);
			if (block.isSink())
				sink_list.add(block);
			if (block.isDefeat())
				defeat_list.add(block);
			if (block.isHot())
				hot_list.add(block);
		}
	}
	
	/**
	 * Start a level
	 * 
	 * @param fname the file name
	 * @return void
	 */
	public void startLevel (String fname) {
		if (fname.startsWith("niveau")){
			levelBuilder(fname,0);
		} else {
			for (int i = 0; i < 8; i++) {
				levelBuilder(fname, i);
			}
		}
	}
	
	/**
	 * Create the game board
	 * 
	 * @param context the context used
	 * @param fname the file name
	 * @param level the level loaded
	 * @return Board
	 */
	private Board createBoard(ApplicationContext context, String fname, int level) {
		ScreenInfo screenInfo = context.getScreenInfo();
		int width = (int)screenInfo.getWidth();
		int height = (int)screenInfo.getHeight();
		level(fname, level);
		Board board = new Board(width, height);
		setBoard(board);
		return board;
	}
	
	/**
	 * Draw all of the block in the level loaded and set all of the block properties
	 * 
	 * @param context the context used
	 * @param board the game board
	 * @return void
	 */
	private void setAll(ApplicationContext context, Board board) {
		context.renderFrame(graphics -> drawBoard(graphics, board, win_list, sink_list, defeat_list, remove_list));
		setBlockProp(board, win_list, sink_list, defeat_list, hot_list);
	}
	
	/**
	 * Remove block if needed
	 * 
	 * @return void
	 */
	private void removeBlock() {
		/* CHECK CONDITION */
		for (BiYBlock block : Board.getBlockList())
			BiYConditions.conditionsCheckers(block, defeat_list, sink_list, hot_list);
		/******************/

		/* REMOVE BLOCK */
		for (BiYBlock block : remove_list)
			Board.getBlockList().remove(block);
		/****************/
	}
	
	/**
	 * Build and play the level chosen
	 * 
	 * @param fname the file name
	 * @param level the level chosen
	 * @return void
	 */
	private void levelBuilder (String fname, int level){
		Application.run(Color.BLACK, context -> {
			Board board = createBoard(context, fname, level);
			while (true){
				setAll(context, board);
				Event event = context.pollOrWaitEvent(200);
				if (event == null) continue;
				Event.Action action = event.getAction();
				if (action == Event.Action.POINTER_DOWN || action == Event.Action.POINTER_UP) {
					context.exit(0);
					return;
				}
				if (action == Event.Action.KEY_PRESSED) {
					KeyboardKey key = event.getKey();
					for (BiYBlock block : Board.getBlockList()) {
						if (block.isYou()) {
							if (BiYConditions.checkCondition(win_list, block)) {
								System.out.println("GAGNÉ !");
								Board.getBlockList().clear();
								if (fname.startsWith("niveau")) context.exit(0);
								else if (level == 7) context.exit(0);
								return;
							}
							BiYMove.full_move(key, block, board);
						}
					}
					removeBlock();
				}
			}
		});
	}

	/**
	 * Convert a String into a BiYBlockType
	 * 
	 * @param type the string that will be convert
	 * @return BiYBlockType
	 */
	private BiYBlockType StringToEnum (String type){
		Objects.requireNonNull(type);
		return switch (type) {
			case "BABA" -> BiYBlockType.BABA;
			case "FLAG" -> BiYBlockType.FLAG;
			case "LAVA" -> BiYBlockType.LAVA;
			case "ROCK" -> BiYBlockType.ROCK;
			case "SKULL" -> BiYBlockType.SKULL;
			case "WALL" -> BiYBlockType.WALL;
			case "WATER" -> BiYBlockType.WATER;
			case "DOLLAR" -> BiYBlockType.DOLLAR;
			case "IS" -> BiYBlockType.IS;
			case "YOU" -> BiYBlockType.YOU;
			case "WIN" -> BiYBlockType.WIN;
			case "STOP" -> BiYBlockType.STOP;
			case "PUSH" -> BiYBlockType.PUSH;
			case "HOT" -> BiYBlockType.HOT;
			case "MELT" -> BiYBlockType.MELT;
			case "DEFEAT" -> BiYBlockType.DEFEAT;
			case "SINK" -> BiYBlockType.SINK;
			case "SLIDE" -> BiYBlockType.SLIDE;
			default -> throw new IllegalArgumentException("Enum not valid");
		};
	}
}