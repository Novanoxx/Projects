package fr.vong_xu.proj.entity;

public enum BiYBlockType {
	BABA(0),
	FLAG(1),
	LAVA(2),
	ROCK(3),
	SKULL(4),
	WALL(5),
	WATER(6),
	DOLLAR(7),

	IS(8),
	
	YOU(9),
	WIN(10),
	STOP(11),
	PUSH(12),
	MELT(13),
	HOT(14),
	DEFEAT(15),
	SINK(16),
	SLIDE(17);

	private int value;

	/**
	 * Setter for value
	 * 
	 * @param value
	 */
	private BiYBlockType(int value) {
		this.value = value;
	}
	
	/**
	 * Getter for value
	 * 
	 * @return
	 */
	public int getValue() {
		return value;
	}
}
