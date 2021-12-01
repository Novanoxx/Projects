package fr.vong_xu.proj.board;

import java.util.ArrayList;
import java.util.List;
import java.util.Objects;

import fr.vong_xu.proj.entity.BiYBlock;

public class Board {
	private int width;
	private int height;
	private int squareX;
	private int squareY;
	
	private static final List<BiYBlock> blockList = new ArrayList<>();
	private static final List<BiYBlock> subList = new ArrayList<>();
	
	/**
	 * Initiate the class Board
	 * 
	 * @param width the width given
	 * @param height the height given
	 */
	public Board(int width, int height) {
		if (width <= 0 || height <= 0)
			throw new IllegalArgumentException("Every arguments must be positive and over 0 !\n");
		this.width = width;
		this.height = height;
	}
	
	/**
	 * Return the width of the class
	 * @return integer
	 */
	public int width() {
		return this.width;
	}
	
	/**
	 * Return the height of the class
	 * @return integer
	 */
	public int height() {
		return this.height;
	}
	
	/**
	 * Return the squareX of the class
	 * @return integer
	 */
	public int squareX() {
		return this.squareX;
	}
	
	/**
	 * Return the squareY of the class
	 * @return integer
	 */
	public int squareY() {
		return this.squareY;
	}
	
	/**
	 * Setter of squareX
	 * @param squareX the new squareX
	 * @return void
	 */
	public void setSquareX(int squareX) {
		this.squareX = squareX;
	}
	
	/**
	 * Setter of squareY
	 * @param squareY the new squareY
	 * @return void
	 */
	public void setSquareY(int squareY) {
		this.squareY = squareY;
	}
	
	/**
	 * Add the block "block" in the list "list"
	 * 
	 * @param list the list which will have the block
	 * @param block the block which will be add
	 * @return void
	 */
	public void add(List<BiYBlock> list, BiYBlock block) {
		Objects.requireNonNull(block);
		list.add(block);
	}
	
	/**
	 * Return the blockList of the class
	 * @return List<BiYBlock>
	 */
	public static List<BiYBlock> getBlockList() {
		return blockList;
	}
	
	/**
	 * Return the subList of the class
	 * @return List<BiYBlock>
	 */
	public static List<BiYBlock> getSubList() {
		return subList;
	}
	
	/**
	 * Get the block in terms of the x and the y
	 * 
	 * @param x the x of a block given
	 * @param y the y of a block given
	 * @return BiYBlock
	 */
	public BiYBlock getBiYBlock(int x, int y){
		int i;
		
		for (i = 0; i < blockList.size(); i++) {
			if(blockList.get(i).getX() == x && blockList.get(i).getY() == y)
				return blockList.get(i);
		}
		return null;
	}
	
	/**
	 * Fill the subList of the possible block at this x and y given
	 * 
	 * @param x the x of a block given
	 * @param y the y of the block given
	 */
	public void fillSubList(int x, int y){
		int i;
		
		for (i = 0; i < blockList.size(); i++) {
			if(blockList.get(i).getX() == x && blockList.get(i).getY() == y)
				add(subList, blockList.get(i));
		}
	}
	
	/**
	 * Clear subList
	 * 
	 * @return void
	 */
	public void freeSubList() {
		subList.clear();
	}
}

