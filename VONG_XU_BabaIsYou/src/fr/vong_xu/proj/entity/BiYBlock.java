package fr.vong_xu.proj.entity;

import java.awt.Graphics2D;
import java.util.Objects;

import javax.swing.ImageIcon;

import fr.vong_xu.proj.board.Board;

public class BiYBlock {
	private final String[] paths = {
					"resource/picture/BABA/BABA_0.gif",
					"resource/picture/FLAG/FLAG_0.gif",
					"resource/picture/LAVA/LAVA_0.gif",
					"resource/picture/ROCK/ROCK_0.gif",
					"resource/picture/SKULL/SKULL_0.gif",
					"resource/picture/WALL/WALL_0.gif",
					"resource/picture/WATER/WATER_0.gif",
					"resource/picture/DOLLAR/DOLLAR_0.png",

					"resource/picture/IS/Text_IS_0.png",

					"resource/picture/YOU/Text_YOU_0.gif",
					"resource/picture/WIN/Text_WIN_0.gif",
					"resource/picture/STOP/Text_STOP_0.gif",
					"resource/picture/PUSH/Text_PUSH_0.gif",
					"resource/picture/MELT/Text_MELT_0.gif",
					"resource/picture/HOT/Text_HOT_0.gif",
					"resource/picture/DEFEAT/Text_DEFEAT_0.gif",
					"resource/picture/SINK/Text_SINK_0.gif",
					"resource/picture/SLIDE/Text_SLIDE_0.png",

					"resource/picture/BABA/Text_BABA_0.gif",
					"resource/picture/FLAG/Text_FLAG_0.gif",
					"resource/picture/LAVA/Text_LAVA_0.gif",
					"resource/picture/ROCK/Text_ROCK_0.gif",
					"resource/picture/SKULL/Text_SKULL_0.gif",
					"resource/picture/WALL/Text_WALL_0.gif",
					"resource/picture/WATER/Text_WATER_0.gif",
					"resource/picture/DOLLAR/Text_DOLLAR_0.png"
	};
	private int pic_number = 8;
	private int x;
	private int y;
	private boolean isText = false;
	private ImageIcon pic;
	private String url;
	private BiYBlockType type;
	private boolean win = false;
	private boolean you = false;
	private boolean stop = false;
	private boolean melt = false;
	private boolean hot = false;
	private boolean defeat = false;
	private boolean sink = false;
	private boolean push = false;
	private boolean slide = false;
	
	/**
	 * The constructor of the class BiYBlock
	 * 
	 * @param x the x chosen by the user
	 * @param y the y chosen by the user
	 * @param type the type chosen by the user
	 * @param isText boolean showing if the BiYBlock is a text or not (for a type that can be a text or not)
	 */
	public BiYBlock(int x, int y, BiYBlockType type, boolean isText) {
		Objects.requireNonNull(type);

		this.x = x;
		this.y = y;
		this.isText = isText;
		if (isText && type.getValue() < pic_number) {
			this.url = paths[type.getValue() + (pic_number + 10)];
		} else {
			this.url = paths[type.getValue()];
		}
		setImage(this.url);
		this.type = type;
	}
	
	/**
	 * Getter for x
	 * 
	 * @return integer
	 */
	public int getX() {
		return this.x;
	}
	
	/**
	 * Setter for x
	 * 
	 * @param x the new x wanted
	 */
	public void new_x(int x) {
		this.x = x;
	}
	
	/**
	 * Getter for y
	 * 
	 * @return integer
	 */
	public int getY() {
		return this.y;
	}
	
	/**
	 * Setter for y
	 * 
	 * @param y the new y wanted
	 */
	public void new_y(int y) {
		this.y = y;
	}
	
	/**
	 * Getter for type
	 * 
	 * @return BiYBlockType
	 */
	public BiYBlockType getType() {
		return this.type;
	}
	
	/**
	 * Convert "info" into pixel
	 * 
	 * @param info the x or y from a BiYBlock
	 * @param size the size of the board 
	 * @param square the number of square
	 * @return integer
	 */
	private int caseToPixel(int info, int direction, int square) {
		return info * direction/square;
	}
	
	/**
	 * Draw the picture of the block
	 * 
	 * @param graphics the context used
	 * @param board the game board use
	 * @return void
	 */
	public void draw(Graphics2D graphics, Board board) {
		Objects.requireNonNull(graphics);
		Objects.requireNonNull(board);
		graphics.drawImage(pic.getImage(), caseToPixel(x, board.width(), board.squareX()),
								caseToPixel(y, board.height(), board.squareY()),
								board.width()/board.squareX(), board.height()/board.squareY(), null);
	}
	
	/**
	 * Setter for pic
	 * 
	 * @param newUrl the string that contain the location of the new picture
	 * @return void
	 */
	private void setImage(String newUrl){
			this.pic = new ImageIcon(newUrl);
	}
	
	/**
	 * Change the type of the block
	 * 
	 * @param newType the new type for the block
	 * @return void
	 */
	public void changeType (BiYBlockType newType){
		if ((isText) && (newType.getValue() < pic_number)){
			this.url = paths[newType.getValue() + (pic_number + 9)];
		} else {
			this.url = paths[newType.getValue()];
			this.type = newType;
			setImage(this.url);
		}
	}
	
	/**
	 * Set all property to false
	 * 
	 * @return void
	 */
	public void resetAllProperty (){
		if (this.isBlock()) {
			this.setYou(false);
			this.setWin(false);
			this.setStop(false);
			this.setPush(false);
			this.setMelt(false);
			this.setHot(false);
			this.setDefeat(false);
			this.setSink(false);
			this.setSlide(false);
		}
	}
	
	/**
	 * Check if the block is a block with no property set to true
	 * 
	 * @return boolean
	 */
	public boolean voidBlock() {
		return !isYou() && !isWin() && !isStop() && !canPush() &&
				!isMelt() && !isHot() && !isDefeat() && !isSink();
	}
	
	/**
	 * Check if the block do an action (Melt/Hot excluded)
	 * 
	 * @return boolean
	 */
	public boolean effectBlock() {
		return isWin() || isDefeat() || isSink();
	}
	
	/**
	 * Check if the class is a block
	 * 
	 * @return boolean
	 */
	public boolean isBlock(){
		return this.type.compareTo(BiYBlockType.IS) < 0;
	}
	
	/**
	 * Check if the class is a text
	 * 
	 * @return boolean
	 */
	public boolean isText(){
		return this.isText;
	}
	
	/**
	 * Check if the class is a property
	 * 
	 * @return boolean
	 */
	public boolean isProperty() {
		return this.type.compareTo(BiYBlockType.YOU) >= 0;
	}
	
	/**
	 * Getter for win
	 * 
	 * @return boolean
	 */
	public boolean isWin(){
		return win;
	}
	
	/**
	 * Setter for win
	 * 
	 * @param state the state that win will have
	 * @return void
	 */
	public void setWin(boolean state) {
		this.win = state;
	}
	
	/**
	 * Getter for you
	 * 
	 * @return boolean
	 */
	public boolean isYou(){
		return you;
	}
	
	/**
	 * Setter for you
	 * 
	 * @param state the state that you will have
	 * @return void
	 */
	public void setYou(boolean state) {
		this.you = state;
	}
	
	/**
	 * Getter for stop
	 * 
	 * @return boolean
	 */
	public boolean isStop(){
		return stop;
	}
	
	/**
	 * Setter for stop
	 * 
	 * @param state the state that stop will have
	 * @return void
	 */
	public void setStop(boolean state) {
		this.stop = state;
	}
	
	/**
	 * Getter for Melt
	 * 
	 * @return boolean
	 */
	public boolean isMelt(){
		return melt;
	}
	
	/**
	 * Setter for melt
	 * 
	 * @param state the state that melt will have
	 * @return void
	 */
	public void setMelt(boolean state) {
		this.melt = state;
	}
	
	/**
	 * Getter for hot
	 * 
	 * @return boolean
	 */
	public boolean isHot(){
		return hot;
	}
	
	/**
	 * Setter for hot
	 * 
	 * @param state the state that hot will have
	 * @return void
	 */
	public void setHot(boolean state) {
		this.hot = state;
	}

	/**
	 * Getter for defeat
	 * 
	 * @return boolean
	 */
	public boolean isDefeat(){
		return defeat;
	}
	
	/**
	 * Setter for defeat
	 * 
	 * @param state the state that defeat will have
	 * @return void
	 */
	public void setDefeat(boolean state) {
		this.defeat = state;
	}
	
	/**
	 * Getter for sink
	 * 
	 * @return boolean
	 */
	public boolean isSink(){
		return sink;
	}
	
	/**
	 * Setter for sink
	 * 
	 * @param state the state that sink will have
	 * @return void
	 */
	public void setSink(boolean state) {
		this.sink = state;
	}
	
	/**
	 * Getter for push
	 * 
	 * @return boolean
	 */
	public boolean canPush(){
		return push;
	}
	
	/**
	 * Setter for push
	 * 
	 * @param state the state that push will have
	 * @return void
	 */
	public void setPush(boolean state) {
		this.push = state;
	}
	
	/**
	 * Getter for slide
	 * 
	 * @return boolean
	 */
	public boolean canSlide(){
		return slide;
	}
	
	/**
	 * Setter for slide
	 * 
	 * @param state the state that slide will have
	 * @return void
	 */
	public void setSlide(boolean state) {
		this.slide = state;
	}
	
	/**
	 * Check the block beside (left or right) of a IS block
	 * 
	 * @param board the game board
	 * @return void
	 */
	public void leftRightProperty (Board board) {
		Objects.requireNonNull(board);
		
		if (!(this.type == BiYBlockType.IS))
			return;
		
	    var left_text = board.getBiYBlock(x - 1, y);
	    var right_text = board.getBiYBlock(x + 1, y);
	    if ((left_text == null || right_text == null))
	    	return;
		conditionIs(left_text, right_text);
	}
	
	/**
	 * Check the block above or beside of a IS block
	 * 
	 * @param board the game board
	 * @return void
	 */
	public void upDownProperty (Board board) {
		Objects.requireNonNull(board);

		if (!(this.type == BiYBlockType.IS))
			return;
		var up_text = board.getBiYBlock(x, y - 1);
		var down_text = board.getBiYBlock(x, y + 1);
		if ((up_text == null || down_text == null))
			return;
		conditionIs(up_text, down_text);
	}
	
	/**
	 * Set a property a true if a block must have it on true
	 * 
	 * @param property
	 * @param block
	 */
	private void hasProperty(BiYBlock property, BiYBlock block){
		Objects.requireNonNull(property);
		switch (property.getType().getValue()) {
	  		case 9 -> block.setYou(true);
	  		case 10 -> block.setWin(true);
	  		case 11 -> block.setStop(true);
	  		case 12 -> block.setPush(true);
	  		case 13 -> block.setMelt(true);
	  		case 14 -> block.setHot(true);
	  		case 15 -> block.setDefeat(true);
	  		case 16 -> block.setSink(true);
	  		case 17 -> block.setSlide(true);
	  		default -> throw new IllegalArgumentException("No property !");
		}
	}
	
	/**
	 * Do the role that the block IS have, check the left/right texts of IS or if not, the up/down texts of IS
	 * 
	 * @param firstblock the block located at the left or above IS
	 * @param secondblock the block located at the right or below IS
	 * @return void
	 */
	private void conditionIs(BiYBlock firstblock, BiYBlock secondblock) {
		Objects.requireNonNull(firstblock);
		Objects.requireNonNull(secondblock);
		if (firstblock.isText()) {
			if (secondblock.isText()) {
				for (BiYBlock block : Board.getBlockList()) {
					if(block.getType().getValue() == firstblock.getType().getValue() && !block.isText){
						block.changeType(BiYBlockType.values()[secondblock.getType().getValue()]);
					}
				}
			} else if (secondblock.isProperty()) {
				for (BiYBlock block : Board.getBlockList()) {
					if (block.getType().getValue() == firstblock.getType().getValue() && !block.isText)
						hasProperty(secondblock, block);
				}
			}
		}
	}
}