package fr.vong_xu.proj.entity;

import java.util.Objects;

import fr.umlv.zen5.KeyboardKey;
import fr.vong_xu.proj.board.Board;

public class BiYMove {
	/**
     * Allow to know which direction is chosen
     * 
     * @param key the key pressed by the user
     * @return integer
     */
	private static int cardinal(KeyboardKey key) {
		if (key == KeyboardKey.DOWN || key == KeyboardKey.RIGHT)
			return 1;
		return -1;
	}
	
	/**
     * Find the block next to the pusher
     * 
     * @param key the key pressed by the user
     * @param choice allow to know if the move is horizontal or vertical
     * @param pusher block which will push the victim
     * @param board the game board
     * @return BiYBlock
     */
	private static BiYBlock find_victim(KeyboardKey key, int choice, BiYBlock pusher, Board board) {
		if (choice == 1)
			return board.getBiYBlock(pusher.getX(), pusher.getY() + cardinal(key));
		return board.getBiYBlock(pusher.getX() + cardinal(key), pusher.getY());
	}
	
	/**
     * Make the block "block" slide
     * 
     * @param block the block which have slide at true
     * @param victim the block which will stop the block "block"
     * @param choice allow to know if the move is horizontal or vertical
     * @param key the key pressed by the user
     * @param board the game board
     * @return void
     */
	private static void slideYou(BiYBlock block, BiYBlock victim, int choice, KeyboardKey key, Board board) {
		int coordX;
		int coordY;
		if (victim != null) victim = chooseGoodBlock(victim, board);
		while ((victim == null || (victim != null && (victim.voidBlock() || victim.effectBlock() || victim.isHot() ) ) )) {
			coordX = block.getX();
			coordY = block.getY();
			BiYMove.move(key, block, board);
			if ((coordX == block.getX() && coordY == block.getY())
				|| ((victim != null && (victim.effectBlock() || (victim.isHot() && block.isMelt()) ))) )
				break;
			victim = find_victim(key, choice, block, board);
			if (victim != null)
				victim = chooseGoodBlock(victim, board);
		}
	}
	
	/**
     * Choose push(), move() or slideYou()
     * 
     * @param key the key pressed by the user
     * @param choice allow to know if the move is horizontal or vertical
     * @param pusher the block which will move
     * @param board the game board
     * @return void
     */
	private static void choice_move(KeyboardKey key, int choice, BiYBlock pusher, Board board) {
		BiYBlock victim = find_victim(key, choice, pusher, board);
		if (victim != null && !chooseGoodBlock(victim, board).voidBlock()) {
			victim = chooseGoodBlock(victim, board);
			if (pusher.isYou() && victim.canPush())
				push(key, pusher, board);
			else if (pusher.isYou() && !victim.isStop())
				move(key, pusher, board);
		}
		if (victim == null || (victim != null && chooseGoodBlock(victim, board).voidBlock()) ) {
			if (pusher.isYou() && !pusher.canSlide())
				move(key, pusher, board);
			else if (pusher.isYou() && pusher.canSlide())
				slideYou(pusher, victim, choice, key, board);
		}
	}
	
	/**
     * Check if the move is valid
     * 
     * @param key the key pressed by the user
     * @param info the x or y of a block
     * @param limit the limit of the game board
     * @return boolean
     */
	private static boolean valid_move(KeyboardKey key, int info, int limit) {
		if (key == KeyboardKey.DOWN || key == KeyboardKey.RIGHT)
			return info < limit - 1;
		if (key == KeyboardKey.UP || key == KeyboardKey.LEFT)
			return limit < info;
		return false;
	}
	
	/**
     * Move the block "block"
     * 
     * @param key the key pressed by the user
     * @param block the block which will be moving
     * @param board the game board
     * @return void
     */
	public static void move(KeyboardKey key, BiYBlock block, Board board) {
		Objects.requireNonNull(key);
		Objects.requireNonNull(block);
		Objects.requireNonNull(board);
		
		if (key == KeyboardKey.DOWN && (valid_move(key, block.getY(), board.squareY())) && !block.isStop())
			block.new_y(block.getY() + 1);
		if (key == KeyboardKey.UP && (valid_move(key, block.getY(), 0)) && !block.isStop())
			block.new_y(block.getY() - 1);
		if (key == KeyboardKey.RIGHT && (valid_move(key, block.getX(), board.squareX())) && !block.isStop())
			block.new_x(block.getX() + 1);
		if (key == KeyboardKey.LEFT && (valid_move(key, block.getX(), 0)) && !block.isStop())
			block.new_x(block.getX() - 1);
	}
	
	/**
     * Initiate the move, push or slide
     * 
     * @param key the key pressed by the user
     * @param pusher the block that will move
     * @param board the game board
     * @return void
     */
	public static void full_move(KeyboardKey key, BiYBlock pusher, Board board) {
		int save = 0;
		int choice = 0;
		if (key == KeyboardKey.DOWN || key == KeyboardKey.UP) {
			save = pusher.getY();
			choice = 1;
		}
		if (key == KeyboardKey.LEFT || key == KeyboardKey.RIGHT)
			save = pusher.getX();
		choice_move(key, choice, pusher, board);
		BiYBlock victim = find_victim(key, choice, pusher, board);
		if (victim != null && victim.canPush()) {
			if (BiYConditions.inAnother(pusher, victim) && choice == 1)
	    		pusher.new_y(save);
	    	if (BiYConditions.inAnother(pusher, victim) && choice == 0)
	    		pusher.new_x(save);
		}
	}	
	
	/**
     * Check the next block in the list blockList
     * 
     * @param key the key pressed by the user
     * @param block the block that will be use for searching
     * @param board the game board
     * @return BiYBlock
     */
	private static BiYBlock nextBlock(KeyboardKey key, BiYBlock block, Board board) {
		if (key == KeyboardKey.DOWN)
			return board.getBiYBlock(block.getX(), block.getY() + 1);
		if (key == KeyboardKey.UP)
			return board.getBiYBlock(block.getX(), block.getY() - 1);
		if (key == KeyboardKey.LEFT)
			return board.getBiYBlock(block.getX() - 1, block.getY());
		if (key == KeyboardKey.RIGHT)
			return board.getBiYBlock(block.getX() + 1, block.getY());
		return null;
	}
	
	/**
     * Return the opposite of the key given
     * 
     * @param key the key pressed by the user
     * @return KeyboardKey
     */
	private static KeyboardKey reverseKey(KeyboardKey key) {
		if (key == KeyboardKey.UP)
			return KeyboardKey.DOWN;
		if (key == KeyboardKey.DOWN)
			return KeyboardKey.UP;
		if (key == KeyboardKey.LEFT)
			return KeyboardKey.RIGHT;
		if (key == KeyboardKey.RIGHT)
			return KeyboardKey.LEFT;
		return null;
	}
	
	/**
     * Return the good block in subList so as to move the good block
     * 
     * @param block the block use for searching the good block
     * @param board the game board
     * @return BiYBlock
     */
	private static BiYBlock chooseGoodBlock(BiYBlock block, Board board) {
		BiYBlock actual = block;
		board.fillSubList(block.getX(), block.getY());
		for (BiYBlock choice : Board.getSubList()) {
			if ((!choice.isStop() && moveableBlock(choice)) || choice.isStop()) {
				actual = choice;
				break;
			}
		}
		board.freeSubList();
		return actual;
	}
	
	/**
     * Check if the block can move
     * 
     * @param block the block checked
     * @return boolean
     */
	private static boolean moveableBlock(BiYBlock block) {
		return (block.canPush() || block.isYou());
	}
	
	/**
     * Push all the block that can move
     * 
     * @param key the key pressed by the user
     * @param block the block that will move or not
     * @param board the game board
     * @return void
     */
	public static void push(KeyboardKey key, BiYBlock block, Board board) {
		if (block != null) {
			BiYBlock actual = chooseGoodBlock(block, board);
			if (!actual.isStop() && moveableBlock(actual))
				push(key, nextBlock(key, actual, board), board);
			if (actual.isStop()) return;
			BiYBlock next = nextBlock(key, block, board);
			if (next != null) next = chooseGoodBlock(next, board);
			board.fillSubList(block.getX(), block.getY());
			for (BiYBlock choice : Board.getSubList()) {
				if ((next == null && moveableBlock(choice)) || (next != null && !next.isStop() && moveableBlock(choice)) ) {
					BiYMove.move(key, choice, board);
					if (next != null && BiYConditions.inAnother(next, choice) && ( moveableBlock(next) && moveableBlock(choice) ) )
						BiYMove.move(reverseKey(key), choice, board);
					break;
				}
			}
			board.freeSubList();
		}
	}
}